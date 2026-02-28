<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ProjectCategory::all()->keyBy('slug');

        if ($categories->isEmpty()) {
            $this->call(ProjectCategorySeeder::class);
            $categories = ProjectCategory::all()->keyBy('slug');
        }

        $data = [
            [
                'title' => 'منصة متجر إلكتروني متكاملة',
                'slug' => 'full-ecommerce-platform',
                'short_description' => 'متجر إلكتروني مع سلة مشتريات، بوابة دفع، ولوحة إدارة متقدمة.',
                'description' => 'منصة تجارة إلكترونية مبنية باستخدام Laravel و Vue.js مع دعم متعدد اللغات ولوحة إدارة إحصائيات.',
                'category_slug' => 'web',
                'tags' => 'Laravel, Vue.js, MySQL',
                'demo_url' => 'https://demo.yasinjokhadar.net/ecommerce',
                'code_url' => 'https://github.com/example/ecommerce-demo',
                'order' => 1,
            ],
            [
                'title' => 'لوحة تحكم لإدارة المحتوى (Admin Dashboard)',
                'slug' => 'content-admin-dashboard',
                'short_description' => 'Dashboard تفاعلي لإدارة المحتوى مع Charts و Tables.',
                'description' => 'لوحة تحكم مبنية بـ React و TypeScript مع تصميم حديث وواجهات جاهزة لإدارة بيانات مختلفة.',
                'category_slug' => 'web',
                'tags' => 'React, TypeScript, REST API',
                'demo_url' => 'https://demo.yasinjokhadar.net/dashboard',
                'code_url' => 'https://github.com/example/admin-dashboard',
                'order' => 2,
            ],
            [
                'title' => 'تطبيق مهام شخصي للموبايل',
                'slug' => 'personal-todo-mobile-app',
                'short_description' => 'تطبيق مهام بسيط مع مزامنة سحابية وإشعارات.',
                'description' => 'تطبيق Flutter لإدارة المهام اليومية مع Firebase Authentication و Cloud Firestore.',
                'category_slug' => 'mobile',
                'tags' => 'Flutter, Dart, Firebase',
                'demo_url' => 'https://demo.yasinjokhadar.net/todo-app',
                'code_url' => 'https://github.com/example/todo-mobile',
                'order' => 3,
            ],
            [
                'title' => 'بايبلاين CI/CD لتطبيقات Laravel',
                'slug' => 'laravel-ci-cd-pipeline',
                'short_description' => 'تهيئة GitHub Actions لنشر تحديثات Laravel تلقائياً.',
                'description' => 'مشروع يوضح إعداد CI/CD باستخدام GitHub Actions و Docker و DigitalOcean لتطبيقات Laravel.',
                'category_slug' => 'devops',
                'tags' => 'GitHub Actions, Docker, Laravel',
                'demo_url' => null,
                'code_url' => 'https://github.com/example/laravel-ci-cd',
                'order' => 4,
            ],
            [
                'title' => 'أداة سطر أوامر لنسخ قواعد البيانات احتياطياً',
                'slug' => 'db-backup-cli-tool',
                'short_description' => 'سكربت PHP/Artisan لأخذ نسخ احتياطية مجدولة من قواعد البيانات.',
                'description' => 'أداة CLI مكتوبة بـ PHP تستخدم Laravel Console لجدولة نسخ احتياطية وإرسالها إلى التخزين السحابي.',
                'category_slug' => 'other',
                'tags' => 'PHP, CLI, Backups',
                'demo_url' => null,
                'code_url' => 'https://github.com/example/db-backup-cli',
                'order' => 5,
            ],
        ];

        foreach ($data as $item) {
            $category = $categories[$item['category_slug']] ?? $categories->first();
            if (!$category) {
                continue;
            }

            Project::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'project_category_id' => $category->id,
                    'title' => $item['title'],
                    'slug' => $item['slug'],
                    'short_description' => $item['short_description'],
                    'description' => $item['description'],
                    'tags' => $item['tags'],
                    'demo_url' => $item['demo_url'],
                    'code_url' => $item['code_url'],
                    'order' => $item['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
