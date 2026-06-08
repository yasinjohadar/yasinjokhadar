<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogTagController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\AICourseController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\JourneyCategoryController;
use App\Http\Controllers\Admin\JourneyMilestoneController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ConsultationRequestController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\AppStorageController;
use App\Http\Controllers\Admin\AppStorageAnalyticsController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\BackupScheduleController;
use App\Http\Controllers\Admin\BackupStorageController;
use App\Http\Controllers\Admin\BackupStorageAnalyticsController;
use App\Http\Controllers\Admin\StorageDiskMappingController;
use App\Http\Controllers\Admin\WhatsAppSettingsController;
use App\Http\Controllers\Admin\WhatsAppMessageController;
use App\Http\Controllers\Admin\WhatsAppWebController;
use App\Http\Controllers\Admin\WhatsAppWebSettingsController;
use App\Http\Controllers\Admin\WhatsAppWebhookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SiteSettingController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'check.user.active'])->prefix('admin')->name('admin.')->group(function () {
    // لوحة التحكم الرئيسية
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // المستخدمون
    Route::resource('users', UserController::class);
    Route::post('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // الصلاحيات والأدوار
    Route::resource('roles', RoleController::class);

    // Course Categories & Courses
    Route::resource('course-categories', CourseCategoryController::class);
    Route::post('course-categories/{courseCategory}/toggle-active', [CourseCategoryController::class, 'toggleActive'])->name('course-categories.toggle-active');
    Route::resource('courses', CourseController::class);

    // Course sections & lessons
    Route::post('courses/{course}/sections', [CourseController::class, 'storeSection'])->name('courses.sections.store');
    Route::put('sections/{section}', [CourseController::class, 'updateSection'])->name('sections.update');
    Route::delete('sections/{section}', [CourseController::class, 'deleteSection'])->name('sections.destroy');

    Route::post('sections/{section}/lessons', [CourseController::class, 'storeLesson'])->name('sections.lessons.store');
    Route::put('lessons/{lesson}', [CourseController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('lessons/{lesson}', [CourseController::class, 'deleteLesson'])->name('lessons.destroy');

    // AI Course generation
    Route::get('courses/ai/create', [AICourseController::class, 'create'])->name('courses.ai.create');
    Route::post('courses/ai/generate', [AICourseController::class, 'generate'])->name('courses.ai.generate');
    Route::post('courses/ai', [AICourseController::class, 'store'])->name('courses.ai.store');

    // Project Categories & Projects
    Route::resource('project-categories', ProjectCategoryController::class);
    Route::resource('projects', ProjectController::class);

    // Testimonials
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::resource('testimonials', TestimonialController::class);

    // Videos
    Route::resource('videos', VideoController::class);

    // Gallery images
    Route::resource('gallery-images', GalleryImageController::class);

    // Partners / Clients (شركاؤنا والعملاء)
    Route::resource('partners', PartnerController::class);

    // Journey (محطات المسيرة - حول المدرب)
    Route::resource('journey-categories', JourneyCategoryController::class);
    Route::resource('journey-milestones', JourneyMilestoneController::class);

    // Contact messages (from contact form)
    Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

    // Consultation requests (from consultation booking form)
    Route::get('consultation-requests', [ConsultationRequestController::class, 'index'])->name('consultation-requests.index');
    Route::get('consultation-requests/{consultationRequest}', [ConsultationRequestController::class, 'show'])->name('consultation-requests.show');
    Route::delete('consultation-requests/{consultationRequest}', [ConsultationRequestController::class, 'destroy'])->name('consultation-requests.destroy');

    // Newsletter subscribers
    Route::get('newsletter-subscribers', [NewsletterSubscriberController::class, 'index'])->name('newsletter-subscribers.index');
    Route::get('newsletter-subscribers/export', [NewsletterSubscriberController::class, 'export'])->name('newsletter-subscribers.export');
    Route::delete('newsletter-subscribers/{newsletterSubscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('newsletter-subscribers.destroy');

    // Blog routes
    Route::prefix('blog')->name('blog.')->group(function () {
        // Blog Posts routes
        Route::resource('posts', BlogPostController::class);
        Route::post('posts/{post}/toggle-featured', [BlogPostController::class, 'toggleFeatured'])->name('posts.toggle-featured');
        Route::post('posts/{post}/toggle-publish', [BlogPostController::class, 'togglePublish'])->name('posts.toggle-publish');
        Route::delete('posts/{post}/featured-image', [BlogPostController::class, 'deleteFeaturedImage'])->name('posts.delete-featured-image');
        
        // Blog Categories routes
        Route::resource('categories', BlogCategoryController::class);
        Route::post('categories/{category}/toggle-active', [BlogCategoryController::class, 'toggleActive'])->name('categories.toggle-active');
        
        // Blog Tags routes
        Route::resource('tags', BlogTagController::class);
    });



    // ========== Email Settings Routes ==========
    Route::prefix('settings/email')->name('settings.email.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EmailSettingController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\EmailSettingController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\EmailSettingController::class, 'store'])->name('store');
        Route::post('/test-temp', [\App\Http\Controllers\Admin\EmailSettingController::class, 'testTemp'])->name('test-temp');
        Route::get('/{emailSetting}/edit', [\App\Http\Controllers\Admin\EmailSettingController::class, 'edit'])->name('edit');
        Route::put('/{emailSetting}', [\App\Http\Controllers\Admin\EmailSettingController::class, 'update'])->name('update');
        Route::delete('/{emailSetting}', [\App\Http\Controllers\Admin\EmailSettingController::class, 'destroy'])->name('destroy');
        Route::post('/{emailSetting}/activate', [\App\Http\Controllers\Admin\EmailSettingController::class, 'activate'])->name('activate');
        Route::post('/{emailSetting}/test', [\App\Http\Controllers\Admin\EmailSettingController::class, 'test'])->name('test');
        Route::get('/provider/{provider}', [\App\Http\Controllers\Admin\EmailSettingController::class, 'getProviderPreset'])->name('provider.preset');
    });

    // ========== Site Settings Routes ==========
    Route::prefix('settings/site')->name('settings.site.')->group(function () {
        Route::get('/', [SiteSettingController::class, 'index'])->name('index');
        Route::put('/', [SiteSettingController::class, 'update'])->name('update');
    });

    // ========== App Storage Routes ==========
    Route::prefix('storage')->name('storage.')->group(function () {
        Route::get('/', [AppStorageController::class, 'index'])->name('index');
        Route::get('/create', [AppStorageController::class, 'create'])->name('create');
        Route::post('/', [AppStorageController::class, 'store'])->name('store');
        Route::get('/{config}/edit', [AppStorageController::class, 'edit'])->name('edit');
        Route::put('/{config}', [AppStorageController::class, 'update'])->name('update');
        Route::delete('/{config}', [AppStorageController::class, 'destroy'])->name('destroy');
        Route::post('/{config}/test', [AppStorageController::class, 'test'])->name('test');
        Route::post('/test-connection', [AppStorageController::class, 'testConnection'])->name('test-connection');
        Route::get('/analytics', [AppStorageAnalyticsController::class, 'index'])->name('analytics');
    });

    // ========== Backup Routes ==========
    Route::prefix('backups')->name('backups.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::get('/create', [BackupController::class, 'create'])->name('create');
        Route::post('/', [BackupController::class, 'store'])->name('store');
        Route::get('/{backup}', [BackupController::class, 'show'])->name('show');
        Route::delete('/{backup}', [BackupController::class, 'destroy'])->name('destroy');
        Route::get('/{backup}/download', [BackupController::class, 'download'])->name('download');
        Route::post('/{backup}/restore', [BackupController::class, 'restore'])->name('restore');
        Route::get('/{backup}/status', [BackupController::class, 'status'])->name('status');
        Route::post('/{backup}/run', [BackupController::class, 'run'])->name('run');
    });

    // ========== Backup Schedule Routes ==========
    Route::prefix('backup-schedules')->name('backup-schedules.')->group(function () {
        Route::get('/', [BackupScheduleController::class, 'index'])->name('index');
        Route::get('/create', [BackupScheduleController::class, 'create'])->name('create');
        Route::post('/', [BackupScheduleController::class, 'store'])->name('store');
        Route::get('/{schedule}/edit', [BackupScheduleController::class, 'edit'])->name('edit');
        Route::put('/{schedule}', [BackupScheduleController::class, 'update'])->name('update');
        Route::delete('/{schedule}', [BackupScheduleController::class, 'destroy'])->name('destroy');
        Route::post('/{schedule}/execute', [BackupScheduleController::class, 'execute'])->name('execute');
        Route::post('/{schedule}/toggle-active', [BackupScheduleController::class, 'toggleActive'])->name('toggle-active');
    });

    // ========== Backup Storage Routes ==========
    Route::prefix('backup-storage')->name('backup-storage.')->group(function () {
        Route::get('/', [BackupStorageController::class, 'index'])->name('index');
        Route::get('/create', [BackupStorageController::class, 'create'])->name('create');
        Route::post('/', [BackupStorageController::class, 'store'])->name('store');
        Route::get('/{config}/edit', [BackupStorageController::class, 'edit'])->name('edit');
        Route::put('/{config}', [BackupStorageController::class, 'update'])->name('update');
        Route::delete('/{config}', [BackupStorageController::class, 'destroy'])->name('destroy');
        Route::post('/{config}/test', [BackupStorageController::class, 'test'])->name('test');
        Route::post('/test-connection', [BackupStorageController::class, 'testConnection'])->name('test-connection');
        Route::get('/analytics', [BackupStorageAnalyticsController::class, 'index'])->name('analytics');
    });

    // ========== Storage Disk Mappings Routes ==========
    Route::prefix('storage-disk-mappings')->name('storage-disk-mappings.')->group(function () {
        Route::get('/', [StorageDiskMappingController::class, 'index'])->name('index');
        Route::get('/create', [StorageDiskMappingController::class, 'create'])->name('create');
        Route::post('/', [StorageDiskMappingController::class, 'store'])->name('store');
        Route::get('/{mapping}/edit', [StorageDiskMappingController::class, 'edit'])->name('edit');
        Route::put('/{mapping}', [StorageDiskMappingController::class, 'update'])->name('update');
        Route::delete('/{mapping}', [StorageDiskMappingController::class, 'destroy'])->name('destroy');
    });



    Route::prefix('ai')->name('ai.')->group(function () {
    
        // AI Models
        Route::resource('models', \App\Http\Controllers\Admin\AIModelController::class)->names([
            'index' => 'models.index',
            'create' => 'models.create',
            'store' => 'models.store',
            'show' => 'models.show',
            'edit' => 'models.edit',
            'update' => 'models.update',
            'destroy' => 'models.destroy',
        ]);
        Route::post('models/{model}/test', [\App\Http\Controllers\Admin\AIModelController::class, 'test'])->name('models.test');
        Route::post('models/test-temp', [\App\Http\Controllers\Admin\AIModelController::class, 'testTemp'])->name('models.test-temp');
        Route::post('models/{model}/set-default', [\App\Http\Controllers\Admin\AIModelController::class, 'setDefault'])->name('models.set-default');
        Route::post('models/{model}/toggle-active', [\App\Http\Controllers\Admin\AIModelController::class, 'toggleActive'])->name('models.toggle-active');
        Route::post('models/fetch-groq-models', [\App\Http\Controllers\Admin\AIModelController::class, 'fetchGroqModels'])->name('models.fetch-groq-models');
        
        // Content
        Route::post('content/summarize', [\App\Http\Controllers\Admin\AIContentController::class, 'summarize'])->name('content.summarize');
        Route::post('content/improve', [\App\Http\Controllers\Admin\AIContentController::class, 'improve'])->name('content.improve');
        Route::post('content/grammar-check', [\App\Http\Controllers\Admin\AIContentController::class, 'grammarCheck'])->name('content.grammar-check');
        
        // Settings
        Route::get('settings', [\App\Http\Controllers\Admin\AISettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\Admin\AISettingsController::class, 'update'])->name('settings.update');
    });
    
    /**
     * Blog AI Posts Routes
     * These should be placed in the blog route group
     */
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('ai-posts/create', [\App\Http\Controllers\Admin\AIBlogPostController::class, 'create'])->name('ai-posts.create');
        Route::post('ai-posts', [\App\Http\Controllers\Admin\AIBlogPostController::class, 'store'])->name('ai-posts.store');
        Route::post('ai-posts/generate', [\App\Http\Controllers\Admin\AIBlogPostController::class, 'generate'])->name('ai-posts.generate');
    });

    // WhatsApp Settings Routes
    Route::prefix('whatsapp-settings')
        ->middleware(['role:admin'])
        ->name('whatsapp-settings.')
        ->group(function () {
            Route::get('/', [WhatsAppSettingsController::class, 'index'])->name('index');
            Route::post('/', [WhatsAppSettingsController::class, 'update'])->name('update');
            Route::post('/test-connection', [WhatsAppSettingsController::class, 'testConnection'])->name('test-connection');
        });

    // WhatsApp Messages Routes
    Route::prefix('whatsapp-messages')
        ->middleware(['role:admin'])
        ->name('whatsapp-messages.')
        ->group(function () {
            Route::get('/', [WhatsAppMessageController::class, 'index'])->name('index');
            Route::get('/send', [WhatsAppMessageController::class, 'create'])->name('create');
            Route::get('/search-students', [WhatsAppMessageController::class, 'searchStudents'])->name('search-students');
            Route::post('/send', [WhatsAppMessageController::class, 'send'])->name('send');
            Route::post('/broadcast', [WhatsAppMessageController::class, 'broadcast'])->name('broadcast');
            Route::get('/broadcast/students-count', [WhatsAppMessageController::class, 'getStudentsCount'])->name('broadcast.students-count');
            Route::post('/{message}/retry', [WhatsAppMessageController::class, 'retry'])->name('retry');
            Route::get('/{message}', [WhatsAppMessageController::class, 'show'])->name('show');
        });

    // WhatsApp Web Routes
    Route::prefix('whatsapp-web')
        ->middleware(['role:admin'])
        ->name('whatsapp-web.')
        ->group(function () {
            Route::get('/connect', [WhatsAppWebController::class, 'connect'])->name('connect');
            Route::post('/start-connection', [WhatsAppWebController::class, 'startConnection'])->name('start-connection');
            Route::get('/qr/{sessionId}', [WhatsAppWebController::class, 'getQrCode'])->name('qr');
            Route::get('/status/{sessionId}', [WhatsAppWebController::class, 'getStatus'])->name('status');
            Route::post('/disconnect/{sessionId}', [WhatsAppWebController::class, 'disconnect'])->name('disconnect');
        });

    // WhatsApp Web Settings Routes
    Route::prefix('whatsapp-web-settings')
        ->middleware(['role:admin'])
        ->name('whatsapp-web-settings.')
        ->group(function () {
            Route::get('/', [WhatsAppWebSettingsController::class, 'index'])->name('index');
            Route::post('/', [WhatsAppWebSettingsController::class, 'update'])->name('update');
            Route::post('/test-connection', [WhatsAppWebSettingsController::class, 'testConnection'])->name('test-connection');
        });

});
