<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerTestController;
use App\Models\BlogPost;
use App\Models\Course;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\GalleryImage;
use App\Models\Partner;

// عرض صور الكورسات من التخزين (تجنب 403 عند عدم عمل الرابط الرمزي)
Route::get('/serve/course-image/{filename}', function (string $filename) {
    $path = 'courses/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $mime = match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('filename', '[a-zA-Z0-9_.-]+')->name('course.image');

// عرض صور المدونة (الصورة البارزة) من التخزين
Route::get('/serve/blog-image/{filename}', function (string $filename) {
    $path = 'blog/images/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $mime = match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('filename', '[a-zA-Z0-9_.-]+')->name('blog.image');

// عرض صور الفيديوهات المرفوعة من التخزين
Route::get('/serve/video-image/{filename}', function (string $filename) {
    $path = 'videos/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $mime = match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('filename', '[a-zA-Z0-9_.-]+')->name('video.image');

// عرض صور المعرض من التخزين
Route::get('/serve/gallery-image/{filename}', function (string $filename) {
    $path = 'gallery/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $mime = match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('filename', '[a-zA-Z0-9_.-]+')->name('gallery.image');

// عرض شعارات الشركاء/العملاء من التخزين
Route::get('/serve/partner-logo/{filename}', function (string $filename) {
    $path = 'partners/' . $filename;
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }
    $fullPath = Storage::disk('public')->path($path);
    $mime = match (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
        'jpg', 'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'svg' => 'image/svg+xml',
        default => 'application/octet-stream',
    };
    return response()->file($fullPath, ['Content-Type' => $mime]);
})->where('filename', '[a-zA-Z0-9_.-]+')->name('partner.logo');

// الصفحة الرئيسية
Route::get('/', function () {
    $blogPosts = BlogPost::published()
        ->with('category')
        ->latest('published_at')
        ->take(3)
        ->get();
    $courses = Course::with('category')
        ->active()
        ->orderBy('order')
        ->take(6)
        ->get();
    $testimonials = Testimonial::active()->featured()->orderBy('order')->take(3)->get();
    $videos = Video::active()->featured()->orderBy('order')->take(3)->get();
    $galleryImages = GalleryImage::active()->featured()->orderBy('order')->take(6)->get();
    $partners = Partner::active()->featured()->orderBy('order')->take(3)->get();

    return view('frontend.pages.index', compact('blogPosts', 'courses', 'testimonials', 'videos', 'galleryImages', 'partners'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'check.user.active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/frontend.php';

// اختبار السيرفر — الإصدارات، قاعدة البيانات، ENV، الفرونتند (استخدم ?key=قيمة SERVER_TEST_KEY من .env)
Route::get('/server-test', [ServerTestController::class, 'index'])->name('server.test');