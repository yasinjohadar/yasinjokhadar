<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // تشغيل seeder الصلاحيات أولاً
        $this->call([
            PermissionSeeder::class,
            AdminUserSeeder::class,
        ]);

        // seed المدونة (تصنيفات، وسوم، تدوينات)
        $this->call([
            BlogCategorySeeder::class,
            BlogTagSeeder::class,
            BlogPostSeeder::class,
        ]);

        // seed الكورسات (تصنيفات ثم كورسات)
        $this->call([
            CourseCategorySeeder::class,
            CourseSeeder::class,
        ]);

        // seed المشاريع (تصنيفات ثم مشاريع)
        $this->call([
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
        ]);

        // seed آراء الطلاب
        $this->call([
            TestimonialSeeder::class,
        ]);

        // seed محطات المسيرة (حول المدرب)
        $this->call([
            JourneySeeder::class,
        ]);

        // إنشاء مستخدم تجريبي إضافي
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
        ]);
    }
}
