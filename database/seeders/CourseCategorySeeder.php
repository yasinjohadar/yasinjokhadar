<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'تطوير الويب',
                'slug' => 'web',
                'description' => 'دورات تطوير الويب من Frontend إلى Backend وأطر العمل الحديثة.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'الموبايل',
                'slug' => 'mobile',
                'description' => 'تطوير تطبيقات الهواتف بـ Flutter و React Native.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'بايثون',
                'slug' => 'python',
                'description' => 'لغة بايثون، علوم البيانات والأتمتة.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'أنظمة إدارة المحتوى',
                'slug' => 'cms',
                'description' => 'WordPress وغيره من أنظمة إدارة المحتوى.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Docker، Kubernetes، CI/CD والسحابة.',
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            CourseCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
