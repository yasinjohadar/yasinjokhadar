<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $web = CourseCategory::where('slug', 'web')->first();
        $mobile = CourseCategory::where('slug', 'mobile')->first();
        $python = CourseCategory::where('slug', 'python')->first();
        $cms = CourseCategory::where('slug', 'cms')->first();
        $devops = CourseCategory::where('slug', 'devops')->first();

        if (!$web || !$mobile || !$python || !$cms || !$devops) {
            $this->command->warn('قم بتشغيل CourseCategorySeeder أولاً.');
            return;
        }

        $courses = [
            [
                'course_category_id' => $web->id,
                'title' => 'دورة تطوير الويب الشاملة',
                'slug' => 'web-development-comprehensive',
                'short_description' => 'تعلم HTML, CSS, JavaScript, React وNode.js من الصفر حتى بناء مشاريع حقيقية كاملة',
                'description' => 'دورة عملية شاملة تأخذك من مبتدئ إلى مطور ويب محترف. تشمل أساسيات الويب، Frontend بـ React، وBackend بـ Node.js وExpress.',
                'badge' => 'الأكثر مبيعاً',
                'price' => 49.99,
                'old_price' => 99.99,
                'duration_hours' => 45,
                'lessons_count' => 180,
                'students_count' => 1200,
                'level' => 'من المبتدئ للمتقدم',
                'language' => 'العربية',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'course_category_id' => $python->id,
                'title' => 'بايثون من الصفر إلى الاحتراف',
                'slug' => 'python-from-zero',
                'short_description' => 'تعلم لغة بايثون وعلوم البيانات والأتمتة مع تطبيقات عملية ومشاريع حقيقية',
                'description' => 'دورة متكاملة في بايثون تغطي الأساسيات، البرمجة الكائنية، التعامل مع الملفات وقواعد البيانات، والأتمتة.',
                'badge' => 'جديد',
                'price' => 39.99,
                'old_price' => null,
                'duration_hours' => 35,
                'lessons_count' => 120,
                'students_count' => 800,
                'level' => 'مبتدئ',
                'language' => 'العربية',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'course_category_id' => $mobile->id,
                'title' => 'تطوير تطبيقات الموبايل بـ Flutter',
                'slug' => 'flutter-mobile',
                'short_description' => 'ابنِ تطبيقات موبايل احترافية لـ Android و iOS باستخدام Flutter و Dart',
                'description' => 'تعلم Flutter من الصفر وبناء تطبيقات حقيقية متعددة المنصات مع واجهات حديثة.',
                'badge' => 'متقدم',
                'price' => 44.99,
                'old_price' => null,
                'duration_hours' => 40,
                'lessons_count' => 95,
                'students_count' => 650,
                'level' => 'متوسط',
                'language' => 'العربية',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'course_category_id' => $web->id,
                'title' => 'React.js المتقدم مع TypeScript',
                'slug' => 'react-typescript',
                'short_description' => 'ادخل عالم React المتقدم مع TypeScript, Redux, و Next.js لبناء تطبيقات ويب معقدة',
                'description' => 'دورة متقدمة في React مع TypeScript، إدارة الحالة، Next.js والـ SSR.',
                'badge' => 'شائع',
                'price' => 54.99,
                'old_price' => null,
                'duration_hours' => 30,
                'lessons_count' => 85,
                'students_count' => 520,
                'level' => 'متقدم',
                'language' => 'العربية',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'course_category_id' => $cms->id,
                'title' => 'WordPress من الصفر إلى الاحتراف',
                'slug' => 'wordpress',
                'short_description' => 'تعلم بناء مواقع ووردبريس احترافية وتطوير قوالب وإضافات مخصصة',
                'description' => 'إدارة المحتوى، القوالب، الإضافات، والأمان في ووردبريس.',
                'badge' => 'مطلوب',
                'price' => 34.99,
                'old_price' => null,
                'duration_hours' => 25,
                'lessons_count' => 70,
                'students_count' => 900,
                'level' => 'مبتدئ',
                'language' => 'العربية',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'course_category_id' => $devops->id,
                'title' => 'أساسيات DevOps و Docker',
                'slug' => 'devops-docker',
                'short_description' => 'تعلم أساسيات DevOps, Docker, Kubernetes, CI/CD ونشر التطبيقات على السحابة',
                'description' => 'الحاويات، أتمتة النشر، وخطوط CI/CD مع أدوات مثل Docker و GitHub Actions.',
                'badge' => 'جديد',
                'price' => 39.99,
                'old_price' => null,
                'duration_hours' => 20,
                'lessons_count' => 60,
                'students_count' => 300,
                'level' => 'متوسط',
                'language' => 'العربية',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'course_category_id' => $web->id,
                'title' => 'Node.js و Express.js الشامل',
                'slug' => 'nodejs-express',
                'short_description' => 'تعلم بناء خوادم وAPIs احترافية باستخدام Node.js و Express مع MongoDB',
                'description' => 'Backend كامل مع Node.js، Express، قواعد البيانات، والمصادقة.',
                'badge' => 'أساسي',
                'price' => 42.99,
                'old_price' => null,
                'duration_hours' => 28,
                'lessons_count' => 75,
                'students_count' => 750,
                'level' => 'متوسط',
                'language' => 'العربية',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'course_category_id' => $python->id,
                'title' => 'الذكاء الاصطناعي وتعلم الآلة',
                'slug' => 'ai-machine-learning',
                'short_description' => 'تعلم أساسيات AI و Machine Learning باستخدام Python, TensorFlow و PyTorch',
                'description' => 'مقدمة عملية للذكاء الاصطناعي وتعلم الآلة مع مشاريع تطبيقية.',
                'badge' => 'متقدم',
                'price' => 59.99,
                'old_price' => null,
                'duration_hours' => 38,
                'lessons_count' => 100,
                'students_count' => 400,
                'level' => 'متقدم',
                'language' => 'العربية',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'course_category_id' => $mobile->id,
                'title' => 'React Native للمحترفين',
                'slug' => 'react-native',
                'short_description' => 'تطوير تطبيقات موبايل باستخدام React Native مع Expo والنشر على App Store و Google Play',
                'description' => 'بناء تطبيقات iOS و Android بـ React Native و Expo وإعداد النشر.',
                'badge' => 'محدّث',
                'price' => 47.99,
                'old_price' => null,
                'duration_hours' => 32,
                'lessons_count' => 88,
                'students_count' => 350,
                'level' => 'متوسط',
                'language' => 'العربية',
                'order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }
    }
}
