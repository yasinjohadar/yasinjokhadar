<?php

namespace App\Services\Ai;

use App\Models\AIModel;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AICourseService
{
    public function __construct(
        private AIModelService $modelService
    ) {}

    /**
     * توليد كورس كامل بالذكاء الاصطناعي (تفاصيل + أقسام + دروس)
     */
    public function generateCourse(string $topic, AIModel $model, array $options = []): array
    {
        $language = $options['language'] ?? 'ar';
        $level = $options['level'] ?? 'مبتدئ';
        $sectionsCount = (int) ($options['sections_count'] ?? 4);
        $sectionsCount = max(1, min(15, $sectionsCount));
        $contentDepth = $options['content_depth'] ?? 'medium';
        $category = $options['category'] ?? null;

        set_time_limit(500);

        try {
            $prompt = $this->buildPrompt($topic, $language, $level, $sectionsCount, $contentDepth, $category);

            $provider = AIProviderFactory::create($model);
            $response = $provider->generateText($prompt, [
                'max_tokens' => $model->max_tokens ?? 8000,
                'temperature' => 0.6,
            ]);

            if (empty($response)) {
                Log::warning('Empty response from AI provider', ['topic' => $topic, 'model' => $model->name]);
                throw new \Exception('لم يتم استلام استجابة من موديل AI. يرجى المحاولة مرة أخرى.');
            }

            $data = $this->parseJSONResponse($response);

            if (empty($data['sections']) || !is_array($data['sections'])) {
                Log::warning('AICourseService: invalid structure', [
                    'topic' => $topic,
                    'has_course' => !empty($data['course']),
                    'has_sections' => isset($data['sections']),
                    'response_preview' => mb_substr($response, 0, 800),
                ]);
                throw new \Exception('لم يتم إرجاع هيكل الكورس بشكل صحيح. يرجى المحاولة مرة أخرى.');
            }

            $course = $data['course'] ?? [];
            $sections = $data['sections'];

            $course['slug'] = $course['slug'] ?? $this->generateSlug($course['title'] ?? $topic);
            $course['title'] = $course['title'] ?? $topic;

            $totalMinutes = 0;
            $totalLessons = 0;
            $order = 0;
            foreach ($sections as $i => &$section) {
                $section['order'] = isset($section['order']) ? (int) $section['order'] : $order++;
                $section['lessons'] = $section['lessons'] ?? [];
                foreach ($section['lessons'] as $j => &$lesson) {
                    $lesson['order'] = isset($lesson['order']) ? (int) $lesson['order'] : $j;
                    $lesson['slug'] = $lesson['slug'] ?? $this->generateSlug($lesson['title'] ?? 'lesson-' . ($j + 1));
                    $lesson['duration_minutes'] = isset($lesson['duration_minutes']) ? (int) $lesson['duration_minutes'] : 15;
                    $lesson['is_preview'] = $lesson['is_preview'] ?? false;
                    $totalMinutes += $lesson['duration_minutes'];
                    $totalLessons++;
                }
            }

            $course['duration_hours'] = (int) max(1, ceil($totalMinutes / 60));
            $course['lessons_count'] = $totalLessons;
            $course['short_description'] = $course['short_description'] ?? Str::limit($course['description'] ?? '', 300);
            $course['meta_title'] = $course['meta_title'] ?? Str::limit($course['title'], 60);
            $course['meta_description'] = $course['meta_description'] ?? Str::limit(strip_tags($course['description'] ?? ''), 160);
            $course['highlights'] = $this->ensureLines($course['highlights'] ?? []);
            $course['learn_items'] = $this->ensureLines($course['learn_items'] ?? []);
            $course['requirements'] = $this->ensureLines($course['requirements'] ?? []);

            return [
                'course' => $course,
                'sections' => $sections,
            ];
        } catch (\Exception $e) {
            Log::error('Error generating course: ' . $e->getMessage(), [
                'topic' => $topic,
                'model' => $model->name ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    private function buildPrompt(
        string $topic,
        string $language,
        string $level,
        int $sectionsCount,
        string $contentDepth,
        ?CourseCategory $category
    ): string {
        $langLabel = $language === 'ar' ? 'العربية' : 'English';
        $depthMap = [
            'short' => 'مختصر: كل درس 2-3 فقرات فقط',
            'medium' => 'متوسط: كل درس 4-6 فقرات مع أمثلة بسيطة',
            'full' => 'مفصل: كل درس 8-12 فقرة مع شرح وأمثلة وتمارين',
        ];
        $depthDesc = $depthMap[$contentDepth] ?? $depthMap['medium'];
        $categoryContext = $category ? "التصنيف: {$category->name}. " : '';

        return "أنت مصمم مناهج تعليمية محترف. صمم كورساً تعليمياً متكاملاً باللغة {$langLabel}.

الموضوع/العنوان: {$topic}
{$categoryContext}
المستوى: {$level}
عدد الأقسام المطلوب: {$sectionsCount}
عمق المحتوى: {$depthDesc}

المتطلبات:
1. أنشئ كورساً من {$sectionsCount} أقسام، كل قسم يحتوي على 2-5 دروس.
2. كل درس له: عنوان، slug (باللغة الإنجليزية أو العربية بدون مسافات)، ملخص قصير، محتوى تعليمي (نص أو HTML بسيط: h3, p, ul, ol)، مدة بالدقائق، وترتيب. يمكن جعل الدرس الأول من كل قسم معاينة مجانية (is_preview: true).
3. للكورس: عنوان، slug، وصف قصير، وصف كامل، مستوى، لغة، مدة إجمالية بالساعات، عدد الدروس، نقاط تميز (highlights كقائمة نصوص)، ماذا سيتعلم (learn_items كقائمة نصوص)، المتطلبات السابقة (requirements كقائمة نصوص)، meta_title، meta_description.
4. أرجِع JSON فقط بدون أي نص قبل أو بعد. استخدم هذا الهيكل بالضبط:

{
  \"course\": {
    \"title\": \"عنوان الكورس\",
    \"slug\": \"course-slug\",
    \"short_description\": \"وصف قصير\",
    \"description\": \"وصف كامل HTML\",
    \"level\": \"{$level}\",
    \"language\": \"{$language}\",
    \"duration_hours\": 0,
    \"highlights\": [\"نقطة 1\", \"نقطة 2\"],
    \"learn_items\": [\"سيتعلم 1\", \"سيتعلم 2\"],
    \"requirements\": [\"متطلب 1\"],
    \"meta_title\": \"عنوان SEO\",
    \"meta_description\": \"وصف SEO\"
  },
  \"sections\": [
    {
      \"title\": \"عنوان القسم\",
      \"description\": \"وصف القسم\",
      \"order\": 0,
      \"lessons\": [
        {
          \"title\": \"عنوان الدرس\",
          \"slug\": \"lesson-slug\",
          \"summary\": \"ملخص الدرس\",
          \"content\": \"<p>محتوى الدرس مع HTML بسيط</p>\",
          \"duration_minutes\": 15,
          \"order\": 0,
          \"is_preview\": false
        }
      ]
    }
  ]
}";
    }

    private function generateSlug(string $title): string
    {
        $slug = preg_replace('/\s+/', '-', trim($title));
        $slug = preg_replace('/[^\p{Arabic}a-zA-Z0-9-]/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-') ?: 'item-' . substr(uniqid(), -6);
    }

    private function ensureLines($value): string
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            return implode("\n", array_map('trim', $value));
        }
        return '';
    }

    private function parseJSONResponse(string $response): array
    {
        if (!mb_check_encoding($response, 'UTF-8')) {
            $response = mb_convert_encoding($response, 'UTF-8', 'auto');
            if (!mb_check_encoding($response, 'UTF-8')) {
                $response = mb_convert_encoding($response, 'UTF-8', ['UTF-8', 'ISO-8859-1', 'Windows-1256']);
            }
        }
        $response = mb_convert_encoding($response, 'UTF-8', 'UTF-8');

        // إزالة كتل markdown مثل ```json ... ```
        $response = preg_replace('/^[\s\S]*?```(?:json)?\s*/u', '', $response);
        $response = preg_replace('/\s*```[\s\S]*$/u', '', $response);
        $response = trim($response);

        $jsonStart = strpos($response, '{');
        $jsonEnd = strrpos($response, '}');
        if ($jsonStart === false || $jsonEnd === false || $jsonEnd <= $jsonStart) {
            return [];
        }

        $jsonString = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);

        foreach ([2048, 1024, 512, 256] as $depth) {
            try {
                $decoded = json_decode($jsonString, true, $depth, JSON_INVALID_UTF8_IGNORE);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }
            } catch (\JsonException $e) {
                continue;
            }
        }

        Log::warning('AICourseService: JSON decode failed', [
            'error' => json_last_error_msg(),
            'preview' => mb_substr($jsonString, 0, 500),
        ]);
        return [];
    }
}
