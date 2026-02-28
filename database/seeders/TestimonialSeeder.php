<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'student_name' => 'أحمد محمد',
                'student_title' => 'مطور ويب - سوريا',
                'course_name' => 'دورة تطوير الويب الشاملة',
                'rating' => 5,
                'quote' => 'دورة تطوير الويب كانت نقطة تحول في مسيرتي المهنية. أسلوب الشرح ممتاز والتطبيقات العملية رائعة. أنصح الجميع بالتسجيل!',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'student_name' => 'سارة العلي',
                'student_title' => 'مهندسة برمجيات - الأردن',
                'course_name' => 'دورة بايثون للمبتدئين',
                'rating' => 5,
                'quote' => 'المدرب ياسين من أفضل المدربين العرب. شرحه واضح ومبسط، والمحتوى محدث دائماً بآخر التقنيات.',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'student_name' => 'عمر حسان',
                'student_title' => 'مطور تطبيقات - العراق',
                'course_name' => 'دورة Flutter لتطوير تطبيقات الموبايل',
                'rating' => 4,
                'quote' => 'تعلمت Flutter من الصفر وبنيت أول تطبيق حقيقي خلال فترة قصيرة جداً. المشاريع العملية كانت رائعة.',
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'student_name' => 'محمد خالد',
                'student_title' => 'مطور Backend - مصر',
                'course_name' => 'دورة Node.js المتقدمة',
                'rating' => 5,
                'quote' => 'المحتوى عميق ومنظم، وبعد إكمال الدورة تمكنت من الحصول على أول وظيفة كمطور باكند.',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'student_name' => 'نور الدين',
                'student_title' => 'مطور ويب - تونس',
                'course_name' => 'دورة تطوير الويب الشاملة',
                'rating' => 5,
                'quote' => 'الشرح عملي جداً والتمارين متنوعة. أصبحت قادراً على بناء مواقع متكاملة وحدي.',
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'student_name' => 'لينا أحمد',
                'student_title' => 'مطورة - لبنان',
                'course_name' => 'دورة JavaScript من الصفر',
                'rating' => 4,
                'quote' => 'أفضل استثمار قمت به في تعلم البرمجة. دعم مستمر وأمثلة عملية من سوق العمل.',
                'is_featured' => false,
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                [
                    'student_name' => $data['student_name'],
                    'course_name' => $data['course_name'],
                ],
                $data
            );
        }
    }
}
