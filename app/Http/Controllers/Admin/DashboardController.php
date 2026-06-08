<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ConsultationRequest;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\GalleryImage;
use App\Models\NewsletterSubscriber;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $unreadMessages = $this->safeQuery(fn () => ContactMessage::unread()->count());
        $unreadConsultations = $this->safeQuery(fn () => ConsultationRequest::unread()->count());
        $pendingTestimonials = $this->safeQuery(function () {
            if (! Schema::hasColumn('testimonials', 'status')) {
                return 0;
            }

            return Testimonial::where('status', Testimonial::STATUS_PENDING)->count();
        });

        $coursesCount = $this->safeQuery(fn () => Course::count());
        $projectsCount = $this->safeQuery(fn () => Project::count());
        $blogCount = $this->safeQuery(fn () => BlogPost::count());
        $videosCount = $this->safeQuery(fn () => Video::count());
        $usersCount = $this->safeQuery(fn () => User::count());
        $newsletterActive = $this->safeQuery(fn () => NewsletterSubscriber::active()->count());
        $messagesTotal = $this->safeQuery(fn () => ContactMessage::count());
        $consultationsTotal = $this->safeQuery(fn () => ConsultationRequest::count());

        $summary = [
            'content_items' => $coursesCount + $projectsCount + $blogCount + $videosCount,
            'unread_total' => $unreadMessages + $unreadConsultations,
            'pending_testimonials' => $pendingTestimonials,
            'newsletter_active' => $newsletterActive,
        ];

        $heroStats = [
            [
                'title' => 'إجمالي المحتوى',
                'count' => $summary['content_items'],
                'meta' => $coursesCount.' كورس · '.$projectsCount.' مشروع',
                'icon' => 'bi-collection-play-fill',
                'tone' => 'purple',
            ],
            [
                'title' => 'طلبات التواصل',
                'count' => $messagesTotal + $consultationsTotal,
                'meta' => $summary['unread_total'].' غير مقروءة',
                'icon' => 'bi-chat-dots-fill',
                'tone' => 'green',
            ],
            [
                'title' => 'الكورسات النشطة',
                'count' => $this->safeQuery(fn () => Course::where('is_active', true)->count()),
                'meta' => 'من أصل '.$coursesCount.' كورس',
                'icon' => 'bi-mortarboard-fill',
                'tone' => 'blue',
            ],
            [
                'title' => 'مشتركو النشرة',
                'count' => $newsletterActive,
                'meta' => $usersCount.' مستخدم في النظام',
                'icon' => 'bi-mailbox2-heart-fill',
                'tone' => 'orange',
            ],
        ];

        $todaySummary = [
            [
                'label' => 'رسائل جديدة اليوم',
                'value' => $this->safeQuery(fn () => ContactMessage::whereDate('created_at', today())->count()),
                'icon' => 'bi-envelope-plus-fill',
                'tone' => 'primary',
            ],
            [
                'label' => 'طلبات استشارة اليوم',
                'value' => $this->safeQuery(fn () => ConsultationRequest::whereDate('created_at', today())->count()),
                'icon' => 'bi-calendar-plus-fill',
                'tone' => 'success',
            ],
            [
                'label' => 'آراء بانتظار المراجعة',
                'value' => $pendingTestimonials,
                'icon' => 'bi-chat-square-quote-fill',
                'tone' => 'warning',
            ],
            [
                'label' => 'مقالات المدونة',
                'value' => $blogCount,
                'icon' => 'bi-journal-richtext',
                'tone' => 'info',
            ],
        ];

        $activityChart = $this->buildActivityChart();

        $widgetGroups = [
            [
                'title' => 'إدارة المحتوى',
                'widgets' => [
                    $this->widget('الكورسات', 'bi-mortarboard-fill', 'dash-widget--primary', route('admin.courses.index'), fn () => Course::count(), null, 'إدارة الدورات والمحتوى التعليمي'),
                    $this->widget('المشاريع', 'bi-kanban-fill', 'dash-widget--info', route('admin.projects.index'), fn () => Project::count(), null, 'معرض المشاريع البرمجية'),
                    $this->widget('مقالات المدونة', 'bi-journal-richtext', 'dash-widget--success', route('admin.blog.posts.index'), fn () => BlogPost::count(), null, 'كتابة ونشر التدوينات'),
                    $this->widget('الفيديوهات', 'bi-play-btn-fill', 'dash-widget--danger', route('admin.videos.index'), fn () => Video::count(), null, 'مقاطع يوتيوب والفيديوهات'),
                    $this->widget('معرض الصور', 'bi-images', 'dash-widget--warning', route('admin.gallery-images.index'), fn () => GalleryImage::count(), null, 'صور النشاطات والفعاليات'),
                    $this->widget('آراء الطلاب', 'bi-chat-quote-fill', 'dash-widget--purple', route('admin.testimonials.index'), fn () => Testimonial::count(), $pendingTestimonials > 0 ? $pendingTestimonials.' بانتظار المراجعة' : null, 'مراجعة وموافقة الآراء'),
                    $this->widget('الشركاء والعملاء', 'bi-people-fill', 'dash-widget--teal', route('admin.partners.index'), fn () => Partner::count(), null, 'شعارات الشركاء والعملاء'),
                    $this->widget('محطات المسيرة', 'bi-clock-history', 'dash-widget--orange', route('admin.journey-milestones.index'), fn () => \App\Models\JourneyMilestone::count(), null, 'خط زمني المسيرة المهنية'),
                ],
            ],
            [
                'title' => 'التواصل والطلبات',
                'widgets' => [
                    $this->widget('رسائل التواصل', 'bi-envelope-fill', 'dash-widget--primary', route('admin.contact-messages.index'), fn () => ContactMessage::count(), $unreadMessages > 0 ? $unreadMessages.' غير مقروءة' : null, 'رسائل نموذج التواصل'),
                    $this->widget('طلبات الاستشارة', 'bi-calendar-check-fill', 'dash-widget--success', route('admin.consultation-requests.index'), fn () => ConsultationRequest::count(), $unreadConsultations > 0 ? $unreadConsultations.' جديدة' : null, 'حجوزات الاستشارات'),
                    $this->widget('النشرة البريدية', 'bi-mailbox2', 'dash-widget--info', route('admin.newsletter-subscribers.index'), fn () => NewsletterSubscriber::count(), null, 'مشتركو القائمة البريدية'),
                ],
            ],
            [
                'title' => 'النظام والإعدادات',
                'widgets' => [
                    $this->widget('المستخدمون', 'bi-person-badge-fill', 'dash-widget--dark', route('admin.users.index'), fn () => User::count(), null, 'حسابات لوحة التحكم'),
                    $this->widget('الصلاحيات', 'bi-shield-lock-fill', 'dash-widget--warning', route('admin.roles.index'), fn () => \Spatie\Permission\Models\Role::count(), null, 'الأدوار والصلاحيات'),
                    $this->widget('إعدادات الموقع', 'bi-globe2', 'dash-widget--teal', route('admin.settings.site.index'), null, null, 'الهوية والإعدادات العامة'),
                    $this->widget('النسخ الاحتياطي', 'bi-hdd-stack-fill', 'dash-widget--danger', route('admin.backups.index'), fn () => \App\Models\Backup::count(), null, 'نسخ احتياطية للنظام'),
                    $this->widget('التخزين السحابي', 'bi-cloud-fill', 'dash-widget--info', route('admin.storage.index'), fn () => \App\Models\AppStorageConfig::count(), null, 'S3 وGoogle Drive وغيرها'),
                    $this->widget('نماذج الذكاء الاصطناعي', 'bi-cpu-fill', 'dash-widget--purple', route('admin.ai.models.index'), fn () => \App\Models\AIModel::count(), null, 'إعدادات نماذج AI'),
                ],
            ],
        ];

        $shortcuts = collect($widgetGroups)->flatMap(fn (array $group) => $group['widgets'])->values()->all();

        $recentMessages = $this->safeQuery(fn () => ContactMessage::latest()->take(5)->get(), collect());
        $recentConsultations = $this->safeQuery(fn () => ConsultationRequest::latest()->take(5)->get(), collect());

        return view('admin.dashboard', compact(
            'summary',
            'heroStats',
            'todaySummary',
            'activityChart',
            'shortcuts',
            'recentMessages',
            'recentConsultations',
            'unreadMessages',
            'unreadConsultations',
            'pendingTestimonials'
        ));
    }

    private function widget(
        string $title,
        string $icon,
        string $colorClass,
        string $url,
        ?callable $countCallback = null,
        ?string $badge = null,
        ?string $description = null
    ): array {
        return [
            'title' => $title,
            'icon' => $icon,
            'color' => $colorClass,
            'url' => $url,
            'count' => $countCallback ? $this->safeQuery($countCallback) : null,
            'badge' => $badge,
            'description' => $description,
        ];
    }

    private function buildActivityChart(): array
    {
        $labels = [];
        $messages = [];
        $consultations = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->locale('ar')->translatedFormat('M y');

            $messages[] = $this->safeQuery(function () use ($month) {
                return ContactMessage::query()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            });

            $consultations[] = $this->safeQuery(function () use ($month) {
                return ConsultationRequest::query()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            });
        }

        return [
            'labels' => $labels,
            'series' => [
                ['name' => 'رسائل التواصل', 'data' => $messages],
                ['name' => 'طلبات الاستشارة', 'data' => $consultations],
            ],
        ];
    }

    private function safeQuery(callable $callback, mixed $default = 0): mixed
    {
        try {
            return $callback();
        } catch (\Throwable) {
            return $default;
        }
    }
}
