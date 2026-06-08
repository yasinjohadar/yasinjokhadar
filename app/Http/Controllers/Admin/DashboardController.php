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

        $summary = [
            'content_items' => $this->safeQuery(fn () => Course::count())
                + $this->safeQuery(fn () => Project::count())
                + $this->safeQuery(fn () => BlogPost::count())
                + $this->safeQuery(fn () => Video::count()),
            'unread_total' => $unreadMessages + $unreadConsultations,
            'pending_testimonials' => $pendingTestimonials,
            'newsletter_active' => $this->safeQuery(fn () => NewsletterSubscriber::active()->count()),
        ];

        $widgetGroups = [
            [
                'title' => 'إدارة المحتوى',
                'widgets' => [
                    $this->widget('الكورسات', 'bi-mortarboard-fill', 'dash-widget--primary', route('admin.courses.index'), fn () => Course::count()),
                    $this->widget('المشاريع', 'bi-kanban-fill', 'dash-widget--info', route('admin.projects.index'), fn () => Project::count()),
                    $this->widget('مقالات المدونة', 'bi-journal-richtext', 'dash-widget--success', route('admin.blog.posts.index'), fn () => BlogPost::count()),
                    $this->widget('الفيديوهات', 'bi-play-btn-fill', 'dash-widget--danger', route('admin.videos.index'), fn () => Video::count()),
                    $this->widget('معرض الصور', 'bi-images', 'dash-widget--warning', route('admin.gallery-images.index'), fn () => GalleryImage::count()),
                    $this->widget('آراء الطلاب', 'bi-chat-quote-fill', 'dash-widget--purple', route('admin.testimonials.index'), fn () => Testimonial::count(), $pendingTestimonials > 0 ? $pendingTestimonials.' بانتظار المراجعة' : null),
                    $this->widget('الشركاء والعملاء', 'bi-people-fill', 'dash-widget--teal', route('admin.partners.index'), fn () => Partner::count()),
                    $this->widget('محطات المسيرة', 'bi-clock-history', 'dash-widget--orange', route('admin.journey-milestones.index'), fn () => \App\Models\JourneyMilestone::count()),
                ],
            ],
            [
                'title' => 'التواصل والطلبات',
                'widgets' => [
                    $this->widget('رسائل التواصل', 'bi-envelope-fill', 'dash-widget--primary', route('admin.contact-messages.index'), fn () => ContactMessage::count(), $unreadMessages > 0 ? $unreadMessages.' غير مقروءة' : null),
                    $this->widget('طلبات الاستشارة', 'bi-calendar-check-fill', 'dash-widget--success', route('admin.consultation-requests.index'), fn () => ConsultationRequest::count(), $unreadConsultations > 0 ? $unreadConsultations.' جديدة' : null),
                    $this->widget('النشرة البريدية', 'bi-mailbox2', 'dash-widget--info', route('admin.newsletter-subscribers.index'), fn () => NewsletterSubscriber::count()),
                ],
            ],
            [
                'title' => 'النظام والإعدادات',
                'widgets' => [
                    $this->widget('المستخدمون', 'bi-person-badge-fill', 'dash-widget--dark', route('admin.users.index'), fn () => User::count()),
                    $this->widget('الصلاحيات', 'bi-shield-lock-fill', 'dash-widget--warning', route('admin.roles.index'), fn () => \Spatie\Permission\Models\Role::count()),
                    $this->widget('إعدادات الموقع', 'bi-globe2', 'dash-widget--teal', route('admin.settings.site.index'), null, 'إدارة بيانات الموقع'),
                    $this->widget('النسخ الاحتياطي', 'bi-hdd-stack-fill', 'dash-widget--danger', route('admin.backups.index'), fn () => \App\Models\Backup::count()),
                    $this->widget('التخزين السحابي', 'bi-cloud-fill', 'dash-widget--info', route('admin.storage.index'), fn () => \App\Models\AppStorageConfig::count()),
                    $this->widget('نماذج الذكاء الاصطناعي', 'bi-cpu-fill', 'dash-widget--purple', route('admin.ai.models.index'), fn () => \App\Models\AIModel::count()),
                ],
            ],
        ];

        $recentMessages = $this->safeQuery(fn () => ContactMessage::latest()->take(5)->get(), collect());
        $recentConsultations = $this->safeQuery(fn () => ConsultationRequest::latest()->take(5)->get(), collect());

        return view('admin.dashboard', compact(
            'summary',
            'widgetGroups',
            'recentMessages',
            'recentConsultations',
            'unreadMessages',
            'unreadConsultations',
            'pendingTestimonials'
        ));
    }

    private function widget(string $title, string $icon, string $colorClass, string $url, ?callable $countCallback = null, ?string $badge = null): array
    {
        return [
            'title' => $title,
            'icon' => $icon,
            'color' => $colorClass,
            'url' => $url,
            'count' => $countCallback ? $this->safeQuery($countCallback) : null,
            'badge' => $badge,
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
