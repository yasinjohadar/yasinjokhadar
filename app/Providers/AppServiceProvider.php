<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use App\Events\WhatsAppMessageReceived;
use App\Listeners\AutoReplyWhatsAppListener;
use App\Services\SiteSettingsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // دالة مساعد لعرض صورة تدوينة المدونة من التخزين
        if (!function_exists('blog_image_url')) {
            function blog_image_url(?string $path): string
            {
                if (!$path) {
                    return '';
                }
                return asset('storage/' . ltrim($path, '/'));
            }
        }

        // متغير مسارات أصول الفرونت إند متاح لجميع الـ views
        View::share('fa', asset('frontend/assets'));

        // إعدادات الموقع (تواصل وسوشيال) متاحة لجميع الـ views
        View::share('siteSettings', app(SiteSettingsService::class)->getSettings());

        // تسجيل PermissionServiceProvider
        $this->app->register(PermissionServiceProvider::class);

        // Register WhatsApp auto-reply listener
        Event::listen(
            WhatsAppMessageReceived::class,
            AutoReplyWhatsAppListener::class
        );
    }
}