<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Models\CourseLesson;
use App\Models\AIModel;
use App\Services\Ai\AICourseService;
use App\Services\Ai\AIModelService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AICourseController extends Controller
{
    public function __construct(
        private AICourseService $courseService,
        private AIModelService $modelService
    ) {}

    /**
     * عرض نموذج إنشاء كورس بالذكاء الاصطناعي
     */
    public function create()
    {
        $categories = CourseCategory::orderBy('order')->orderBy('name')->get();
        $models = $this->modelService->getAvailableModels('all');

        return view('admin.courses.ai.create', compact('categories', 'models'));
    }

    /**
     * AJAX endpoint لتوليد محتوى الكورس
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:500',
            'ai_model_id' => 'nullable|exists:ai_models,id',
            'course_category_id' => 'nullable|exists:course_categories,id',
            'language' => 'nullable|in:ar,en',
            'level' => 'nullable|string|max:100',
            'sections_count' => 'nullable|integer|min:1|max:15',
            'content_depth' => 'nullable|in:short,medium,full',
        ]);

        try {
            $model = $validated['ai_model_id']
                ? AIModel::find($validated['ai_model_id'])
                : $this->modelService->getDefaultModel();

            if (!$model) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يوجد موديل AI متاح',
                ], 400);
            }

            $category = isset($validated['course_category_id'])
                ? CourseCategory::find($validated['course_category_id'])
                : null;

            $data = $this->courseService->generateCourse(
                $validated['topic'],
                $model,
                [
                    'language' => $validated['language'] ?? 'ar',
                    'level' => $validated['level'] ?? 'مبتدئ',
                    'sections_count' => $validated['sections_count'] ?? 4,
                    'content_depth' => $validated['content_depth'] ?? 'medium',
                    'category' => $category,
                ]
            );

            $data = $this->cleanUtf8Data($data);

            return response()->json([
                'success' => true,
                'data' => $data,
            ], 200, [], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
        } catch (\Exception $e) {
            Log::error('Error generating course with AI: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'topic' => $validated['topic'] ?? null,
            ]);

            $message = $e->getMessage();
            if (strpos($message, 'timeout') !== false || strpos($message, 'Timeout') !== false) {
                $message = 'انتهت مهلة الاتصال. يرجى المحاولة مرة أخرى أو تقليل عدد الأقسام.';
            } elseif (strpos($message, 'API Key') !== false || strpos($message, 'api key') !== false) {
                $message = 'مشكلة في API Key. يرجى التحقق من إعدادات الموديل.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 500);
        }
    }

    /**
     * حفظ الكورس المولد (كورس + أقسام + دروس)
     */
    public function store(Request $request)
    {
        $payload = $request->input('generated_course');
        if (is_string($payload)) {
            $payload = json_decode($payload, true);
        }

        if (!is_array($payload) || empty($payload['course']) || empty($payload['sections']) || !is_array($payload['sections'])) {
            return redirect()->back()
                ->with('error', 'بيانات الكورس غير صالحة. يرجى توليد المحتوى أولاً.')
                ->withInput();
        }

        $courseCategoryId = $request->input('course_category_id') ?? ($payload['course']['course_category_id'] ?? null);
        if (!$courseCategoryId || !CourseCategory::where('id', $courseCategoryId)->exists()) {
            return redirect()->back()
                ->with('error', 'يجب اختيار تصنيف للكورس.')
                ->withInput();
        }

        $courseData = $payload['course'];
        $sectionsData = $payload['sections'];

        $courseData['course_category_id'] = (int) $courseCategoryId;
        $courseData['title'] = $courseData['title'] ?? 'كورس بدون عنوان';
        $courseData['slug'] = $this->uniqueCourseSlug($courseData['slug'] ?? Str::slug($courseData['title']));
        $courseData['price'] = $courseData['price'] ?? 0;
        $courseData['old_price'] = $courseData['old_price'] ?? null;
        $courseData['order'] = $courseData['order'] ?? ((int) Course::max('order')) + 1;
        $courseData['is_active'] = isset($courseData['is_active']) ? (bool) $courseData['is_active'] : true;
        $courseData['students_count'] = $courseData['students_count'] ?? 0;

        DB::beginTransaction();
        try {
            $course = Course::create([
                'course_category_id' => $courseData['course_category_id'],
                'title' => $courseData['title'],
                'slug' => $courseData['slug'],
                'short_description' => $courseData['short_description'] ?? null,
                'description' => $courseData['description'] ?? null,
                'price' => $courseData['price'],
                'old_price' => $courseData['old_price'],
                'duration_hours' => (int) ($courseData['duration_hours'] ?? 1),
                'lessons_count' => (int) ($courseData['lessons_count'] ?? 0),
                'students_count' => (int) $courseData['students_count'],
                'level' => $courseData['level'] ?? null,
                'language' => $courseData['language'] ?? 'ar',
                'is_active' => $courseData['is_active'],
                'order' => $courseData['order'],
                'meta_title' => $courseData['meta_title'] ?? null,
                'meta_description' => $courseData['meta_description'] ?? null,
                'highlights' => is_array($courseData['highlights'] ?? null) ? implode("\n", $courseData['highlights']) : ($courseData['highlights'] ?? null),
                'learn_items' => is_array($courseData['learn_items'] ?? null) ? implode("\n", $courseData['learn_items']) : ($courseData['learn_items'] ?? null),
                'requirements' => is_array($courseData['requirements'] ?? null) ? implode("\n", $courseData['requirements']) : ($courseData['requirements'] ?? null),
            ]);

            $totalLessons = 0;
            $totalMinutes = 0;

            foreach ($sectionsData as $sectionIndex => $sectionData) {
                $section = CourseSection::create([
                    'course_id' => $course->id,
                    'title' => $sectionData['title'] ?? 'قسم ' . ($sectionIndex + 1),
                    'description' => $sectionData['description'] ?? null,
                    'order' => (int) ($sectionData['order'] ?? $sectionIndex),
                    'is_active' => true,
                ]);

                $lessons = $sectionData['lessons'] ?? [];
                foreach ($lessons as $lessonIndex => $lessonData) {
                    $lessonSlug = $lessonData['slug'] ?? Str::slug($lessonData['title'] ?? 'lesson-' . $lessonIndex);
                    $lessonSlug = $this->uniqueLessonSlug($lessonSlug);

                    CourseLesson::create([
                        'course_section_id' => $section->id,
                        'title' => $lessonData['title'] ?? 'درس ' . ($lessonIndex + 1),
                        'slug' => $lessonSlug,
                        'summary' => $lessonData['summary'] ?? null,
                        'content' => $lessonData['content'] ?? null,
                        'duration_minutes' => (int) ($lessonData['duration_minutes'] ?? 15),
                        'order' => (int) ($lessonData['order'] ?? $lessonIndex),
                        'is_preview' => (bool) ($lessonData['is_preview'] ?? false),
                        'is_active' => true,
                    ]);

                    $totalLessons++;
                    $totalMinutes += (int) ($lessonData['duration_minutes'] ?? 15);
                }
            }

            $course->update([
                'lessons_count' => $totalLessons,
                'duration_hours' => max(1, (int) ceil($totalMinutes / 60)),
            ]);

            DB::commit();

            return redirect()->route('admin.courses.edit', $course)
                ->with('success', 'تم إنشاء الكورس بنجاح باستخدام الذكاء الاصطناعي!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing AI-generated course: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حفظ الكورس: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function uniqueCourseSlug(string $slug): string
    {
        $base = $slug;
        $counter = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }

    private function uniqueLessonSlug(string $slug): string
    {
        $base = $slug;
        $counter = 1;
        while (CourseLesson::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }

    private function cleanUtf8Data($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'cleanUtf8Data'], $data);
        }
        if (is_string($data)) {
            if (!mb_check_encoding($data, 'UTF-8')) {
                $data = mb_convert_encoding($data, 'UTF-8', 'auto');
            }
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
            $data = preg_replace('/^\xEF\xBB\xBF/', '', $data);
            return $data;
        }
        return $data;
    }
}
