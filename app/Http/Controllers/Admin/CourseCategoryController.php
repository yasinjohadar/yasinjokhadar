<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of course categories.
     */
    public function index(Request $request)
    {
        $query = CourseCategory::withCount('courses');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categories = $query->orderBy('order', 'asc')->orderBy('name', 'asc')->paginate(20);

        return view('admin.courses.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.courses.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.unique' => 'اسم التصنيف موجود مسبقاً.',
            'name.required' => 'اسم التصنيف مطلوب.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $counter = 1;
        $originalSlug = $validated['slug'];
        while (CourseCategory::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        if (!isset($validated['order'])) {
            $validated['order'] = (CourseCategory::max('order') ?? 0) + 1;
        }
        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1' ? 1 : 0;

        try {
            CourseCategory::create($validated);
            return redirect()->route('admin.course-categories.index')
                ->with('success', 'تم إنشاء تصنيف الكورسات بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.courses.categories.edit', compact('courseCategory'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $courseCategory->id,
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.unique' => 'اسم التصنيف موجود مسبقاً.',
            'name.required' => 'اسم التصنيف مطلوب.',
        ]);

        $validated['is_active'] = $request->has('is_active') && $request->is_active == '1' ? 1 : 0;

        if ($validated['name'] !== $courseCategory->name) {
            $validated['slug'] = Str::slug($validated['name']);
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (CourseCategory::where('slug', $validated['slug'])->where('id', '!=', $courseCategory->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        try {
            $courseCategory->update($validated);
            return redirect()->route('admin.course-categories.index')
                ->with('success', 'تم تحديث تصنيف الكورسات بنجاح');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(CourseCategory $courseCategory)
    {
        if ($courseCategory->courses()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف التصنيف لأنه يحتوي على كورسات. انقل الكورسات أولاً أو احذفها.');
        }
        try {
            $courseCategory->delete();
            return redirect()->route('admin.course-categories.index')
                ->with('success', 'تم حذف التصنيف بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category active status
     */
    public function toggleActive(CourseCategory $courseCategory)
    {
        $courseCategory->is_active = !$courseCategory->is_active;
        $courseCategory->save();
        return back()->with('success', 'تم تحديث الحالة');
    }
}
