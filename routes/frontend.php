<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestimonialSubmissionController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\NewsletterController;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\GalleryImage;
use App\Models\Partner;
use App\Models\JourneyCategory;
use App\Models\JourneyMilestone;

Route::get('/blog', function () {
    $categories = BlogCategory::active()->withCount('publishedPosts')->orderBy('order')->get();
    $featuredPost = BlogPost::published()
        ->with('category', 'author')
        ->where('is_featured', true)
        ->latest('published_at')
        ->first();
    if (!$featuredPost) {
        $featuredPost = BlogPost::published()->with('category', 'author')->latest('published_at')->first();
    }
    $posts = BlogPost::published()
        ->with('category', 'author')
        ->latest('published_at')
        ->paginate(9);
    return view('frontend.pages.blog', compact('posts', 'categories', 'featuredPost'));
})->name('blog');

Route::get('/blog/{slug}', function ($slug) {
    $post = BlogPost::where('slug', $slug)->published()->with('category', 'author', 'tags')->firstOrFail();
    $recentPosts = BlogPost::published()
        ->where('id', '!=', $post->id)
        ->with('category')
        ->latest('published_at')
        ->take(4)
        ->get();
    $categories = BlogCategory::active()->withCount('publishedPosts')->orderBy('order')->get();
    $prevPost = BlogPost::published()->where('published_at', '>', $post->published_at)->latest('published_at')->first();
    $nextPost = BlogPost::published()->where('published_at', '<', $post->published_at)->oldest('published_at')->first();
    return view('frontend.pages.blog-detail', compact('post', 'recentPosts', 'categories', 'prevPost', 'nextPost'));
})->name('blog.show');

Route::get('/courses', function () {
    $categories = CourseCategory::active()->orderBy('order')->get();
    $query = Course::with('category')->active()->orderBy('order');
    if (request()->filled('category')) {
        $slug = request('category');
        $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
    }
    $courses = $query->get();
    return view('frontend.pages.courses', compact('categories', 'courses'));
})->name('courses');

Route::get('/courses/{slug}', function ($slug) {
    $course = Course::where('slug', $slug)
        ->active()
        ->with([
            'category',
            'sections' => fn ($q) => $q->orderBy('order'),
            'sections.lessons' => fn ($q) => $q->orderBy('order'),
        ])
        ->firstOrFail();
    $relatedCourses = Course::with('category')
        ->active()
        ->where('course_category_id', $course->course_category_id)
        ->where('id', '!=', $course->id)
        ->orderBy('order')
        ->take(4)
        ->get();
    return view('frontend.pages.course-detail', compact('course', 'relatedCourses'));
})->name('course.show');

// الخدمات (المهارات / التخصصات)
$serviceViews = [
    'web'      => 'frontend.pages.service-detail',
    'mobile'   => 'frontend.pages.service-detail-mobile',
    'security' => 'frontend.pages.service-detail-security',
    'servers'  => 'frontend.pages.service-detail-servers',
    'devops'   => 'frontend.pages.service-detail-devops',
];
Route::get('/services/{slug}', function ($slug) use ($serviceViews) {
    if (!array_key_exists($slug, $serviceViews)) {
        abort(404);
    }
    return view($serviceViews[$slug]);
})->name('service.show')->where('slug', 'web|mobile|security|servers|devops');

Route::get('/contact', function () {
    return view('frontend.pages.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

Route::get('/about', function () {
    $journeyCategories = JourneyCategory::active()->orderBy('order')->get();
    $journeyMilestones = JourneyMilestone::with('category')
        ->active()
        ->orderBy('year')
        ->orderBy('order')
        ->get();
    $categorySlug = request('category'); // للرابط المباشر والزر النشط عند التحميل

    return view('frontend.pages.about', compact('journeyCategories', 'journeyMilestones', 'categorySlug'));
})->name('about');

Route::get('/projects', function () {
    $categories = ProjectCategory::active()->orderBy('order')->orderBy('name')->get();
    $projects = Project::with('category')
        ->active()
        ->orderBy('order')
        ->orderBy('title')
        ->get();

    return view('frontend.pages.projects', compact('categories', 'projects'));
})->name('projects');

Route::get('/projects/{slug}', function ($slug) {
    $project = Project::where('slug', $slug)
        ->active()
        ->with(['category', 'images', 'videos', 'features'])
        ->firstOrFail();
    $relatedProjects = Project::with('category')
        ->active()
        ->where('project_category_id', $project->project_category_id)
        ->where('id', '!=', $project->id)
        ->orderBy('order')
        ->take(3)
        ->get();
    return view('frontend.pages.project-detail', compact('project', 'relatedProjects'));
})->name('projects.show');

Route::get('/videos', function () {
    $videos = Video::active()->orderBy('order')->orderByDesc('id')->get();
    return view('frontend.pages.videos', compact('videos'));
})->name('videos');

Route::get('/gallery', function () {
    $galleryImages = GalleryImage::active()->orderBy('order')->orderByDesc('id')->get();
    return view('frontend.pages.gallery', compact('galleryImages'));
})->name('gallery');

Route::get('/testimonials', function () {
    $testimonials = Testimonial::active()
        ->orderBy('order')
        ->orderByDesc('id')
        ->paginate(9);

    return view('frontend.pages.testimonials', compact('testimonials'));
})->name('testimonials');

Route::get('/testimonials/submit', [TestimonialSubmissionController::class, 'create'])->name('testimonials.submit');
Route::post('/testimonials/submit', [TestimonialSubmissionController::class, 'store'])->name('testimonials.submit.store');

Route::get('/consultation', function () {
    return view('frontend.pages.consultation');
})->name('consultation');

Route::post('/consultation', [ConsultationController::class, 'store'])->name('consultation.store');

Route::get('/clients', function () {
    $partners = Partner::active()->orderBy('order')->orderByDesc('id')->get();
    return view('frontend.pages.clients', compact('partners'));
})->name('clients');
