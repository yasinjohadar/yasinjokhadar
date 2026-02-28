<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
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
                'description' => 'مشاريع مواقع وتطبيقات ويب تفاعلية ولوحات تحكم.',
                'icon' => 'fas fa-globe',
                'color' => '#f97316',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'تطبيقات الموبايل',
                'slug' => 'mobile',
                'description' => 'تطبيقات Android و iOS باستخدام Flutter وتقنيات حديثة.',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#0ea5e9',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'أنظمة DevOps والبنية التحتية',
                'slug' => 'devops',
                'description' => 'مشاريع CI/CD، حاويات Docker، وأنظمة مراقبة وخوادم.',
                'icon' => 'fas fa-cloud',
                'color' => '#22c55e',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'أدوات وأتمتة أخرى',
                'slug' => 'other',
                'description' => 'أدوات مساعدة، سكربتات، وأفكار جانبية مفيدة.',
                'icon' => 'fas fa-robot',
                'color' => '#a855f7',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $data) {
            ProjectCategory::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
