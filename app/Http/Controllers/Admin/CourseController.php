<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index(Request $request)
    {
        $query = Course::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('course_category_id', $request->category);
        }

        $courses = $query->orderBy('order', 'asc')->orderBy('title', 'asc')->paginate(15);
        $categories = CourseCategory::orderBy('order')->orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create(Request $request)
    {
        $categories = CourseCategory::orderBy('order')->orderBy('name')->get();
        $course = null;

        if ($request->filled('course_id')) {
            $course = Course::with(['sections.lessons'])->find($request->input('course_id'));
        }

        return view('admin.courses.create', compact('categories', 'course'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_category_id' => 'required|exists:course_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'badge' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'lessons_count' => 'nullable|integer|min:0',
            'students_count' => 'nullable|integer|min:0',
            'level' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'highlights' => 'nullable|string',
            'learn_items' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $counter = 1;
        $originalSlug = $validated['slug'];
        while (Course::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1' ? 1 : 0;
        $validated['order'] = $validated['order'] ?? (Course::max('order') ?? 0) + 1;
        $validated['students_count'] = $validated['students_count'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        try {
            $course = Course::create($validated);

            return redirect()
                ->route('admin.courses.create', ['course_id' => $course->id])
                ->with('success', 'تم إنشاء الكورس، يمكنك الآن إضافة الأقسام والدروس.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $course->load(['sections.lessons']);
        $categories = CourseCategory::orderBy('order')->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_category_id' => 'required|exists:course_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug,' . $course->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'badge' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'lessons_count' => 'nullable|integer|min:0',
            'students_count' => 'nullable|integer|min:0',
            'level' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'highlights' => 'nullable|string',
            'learn_items' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1' ? 1 : 0;
        $validated['students_count'] = $validated['students_count'] ?? 0;

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $validated['image'] = $request->file('image')->store('courses', 'public');
        }

        if (!empty($validated['slug']) && $validated['slug'] !== $course->slug) {
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (Course::where('slug', $validated['slug'])->where('id', '!=', $course->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        } else {
            $validated['slug'] = $course->slug;
        }

        try {
            $course->update($validated);
            return redirect()->route('admin.courses.index')
                ->with('success', 'تم تحديث الكورس بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy(Course $course)
    {
        try {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->delete();
            return redirect()->route('admin.courses.index')
                ->with('success', 'تم حذف الكورس بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Store a new section for the given course.
     */
    public function storeSection(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['course_id'] = $course->id;
        $validated['order'] = $validated['order'] ?? (($course->sections()->max('order') ?? 0) + 1);
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->boolean('is_active') : true;

        $section = CourseSection::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة القسم بنجاح',
                'section' => $section->load('lessons'),
            ]);
        }

        return redirect()
            ->route('admin.courses.edit', $course)
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    /**
     * Update an existing section.
     */
    public function updateSection(Request $request, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->boolean('is_active') : false;

        $section->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث القسم بنجاح',
                'section' => $section->load('lessons'),
            ]);
        }

        return redirect()
            ->route('admin.courses.edit', $section->course_id)
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    /**
     * Delete a section and its lessons.
     */
    public function deleteSection(CourseSection $section)
    {
        $courseId = $section->course_id;
        $section->delete();
        $response = [
            'success' => true,
            'message' => 'تم حذف القسم بنجاح',
        ];

        if (request()->expectsJson()) {
            return response()->json($response);
        }

        return redirect()
            ->route('admin.courses.edit', $courseId)
            ->with('success', $response['message']);
    }

    /**
     * Store a new lesson in a section.
     */
    public function storeLesson(Request $request, CourseSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_lessons,slug',
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0',
            'is_preview' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['course_section_id'] = $section->id;
        $validated['order'] = $validated['order'] ?? (($section->lessons()->max('order') ?? 0) + 1);
        $validated['is_preview'] = $request->boolean('is_preview');
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->boolean('is_active') : true;

        $lesson = CourseLesson::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الدرس بنجاح',
                'lesson' => $lesson,
                'section_id' => $section->id,
            ]);
        }

        return redirect()
            ->route('admin.courses.edit', $section->course_id)
            ->with('success', 'تم إضافة الدرس بنجاح');
    }

    /**
     * Update an existing lesson.
     */
    public function updateLesson(Request $request, CourseLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:course_lessons,slug,' . $lesson->id,
            'summary' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0',
            'is_preview' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_preview'] = $request->boolean('is_preview');
        $validated['is_active'] = $request->has('is_active') ? (bool) $request->boolean('is_active') : false;

        $lesson->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الدرس بنجاح',
                'lesson' => $lesson,
                'section_id' => $lesson->course_section_id,
            ]);
        }

        return redirect()
            ->route('admin.courses.edit', $lesson->section->course_id)
            ->with('success', 'تم تحديث الدرس بنجاح');
    }

    /**
     * Delete a lesson.
     */
    public function deleteLesson(CourseLesson $lesson)
    {
        $courseId = $lesson->section->course_id;
        $lesson->delete();
        $response = [
            'success' => true,
            'message' => 'تم حذف الدرس بنجاح',
            'section_id' => $lesson->course_section_id,
        ];

        if (request()->expectsJson()) {
            return response()->json($response);
        }

        return redirect()
            ->route('admin.courses.edit', $courseId)
            ->with('success', $response['message']);
    }
}
