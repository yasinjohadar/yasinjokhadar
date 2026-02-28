<?php

namespace Database\Seeders;

use App\Models\JourneyCategory;
use App\Models\JourneyMilestone;
use Illuminate\Database\Seeder;

class JourneySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'التعليم الأكاديمي',
                'slug' => 'academic-education',
                'icon' => 'fas fa-graduation-cap',
                'order' => 1,
            ],
            [
                'name' => 'المشوار المهني',
                'slug' => 'professional-career',
                'icon' => 'fas fa-briefcase',
                'order' => 2,
            ],
            [
                'name' => 'الرحلة التدريبية',
                'slug' => 'training-journey',
                'icon' => 'fas fa-chalkboard-teacher',
                'order' => 3,
            ],
        ];

        foreach ($categories as $catData) {
            $cat = JourneyCategory::updateOrCreate(
                ['slug' => $catData['slug']],
                array_merge($catData, ['is_active' => true])
            );
        }

        $academicId = JourneyCategory::where('slug', 'academic-education')->first()?->id;
        $professionalId = JourneyCategory::where('slug', 'professional-career')->first()?->id;
        $trainingId = JourneyCategory::where('slug', 'training-journey')->first()?->id;

        $milestones = [
            [
                'journey_category_id' => $academicId,
                'year' => '2016',
                'title' => 'بداية المشوار',
                'description' => 'بدأت تعلم البرمجة بشكل ذاتي من خلال الموارد المتاحة على الإنترنت، وتعلمت HTML, CSS, و JavaScript.',
                'order' => 0,
            ],
            [
                'journey_category_id' => $professionalId,
                'year' => '2018',
                'title' => 'أول عمل كمطور ويب',
                'description' => 'حصلت على أول فرصة عمل كمطور ويب في شركة تقنية، حيث عملت على مشاريع متعددة باستخدام React و Node.js.',
                'order' => 0,
            ],
            [
                'journey_category_id' => $trainingId,
                'year' => '2019',
                'title' => 'انطلاق التدريب',
                'description' => 'بدأت رحلتي في التدريب والتعليم من خلال تقديم دورات تدريبية محلية ثم التوسع إلى الدورات الأونلاين.',
                'order' => 0,
            ],
            [
                'journey_category_id' => $trainingId,
                'year' => '2021',
                'title' => 'إطلاق منصة الكورسات',
                'description' => 'أطلقت منصتي التعليمية الخاصة وقدمت أكثر من 30 دورة تدريبية في مختلف مجالات البرمجة.',
                'order' => 1,
            ],
            [
                'journey_category_id' => $trainingId,
                'year' => '2023',
                'title' => 'التوسع الدولي',
                'description' => 'توسعت في تقديم الدورات لتشمل عدة دول عربية، وشاركت في مؤتمرات تقنية إقليمية ودولية.',
                'order' => 2,
            ],
            [
                'journey_category_id' => $professionalId,
                'year' => '2026',
                'title' => 'المرحلة الحالية',
                'description' => 'أركز حالياً على تطوير محتوى تعليمي متقدم في مجالات الذكاء الاصطناعي وDevOps والحوسبة السحابية.',
                'order' => 0,
            ],
        ];

        foreach ($milestones as $m) {
            JourneyMilestone::updateOrCreate(
                [
                    'journey_category_id' => $m['journey_category_id'],
                    'year' => $m['year'],
                    'title' => $m['title'],
                ],
                array_merge($m, ['is_active' => true])
            );
        }
    }
}
