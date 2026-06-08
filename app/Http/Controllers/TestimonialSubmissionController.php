<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialSubmissionController extends Controller
{
    public function create()
    {
        $courses = Course::active()->orderBy('title')->get(['id', 'title']);

        return view('frontend.pages.testimonial-submit', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_email' => 'nullable|email|max:255',
            'student_title' => 'nullable|string|max:255',
            'course_name' => 'required|string|max:255',
            'course_other' => 'nullable|string|max:255|required_if:course_name,other',
            'rating' => 'required|integer|min:1|max:5',
            'quote' => 'required|string|min:20|max:2000',
            'avatar' => 'nullable|image|max:2048',
            'consent' => 'accepted',
        ], [
            'student_name.required' => 'يرجى إدخال اسمك.',
            'course_name.required' => 'يرجى اختيار الدورة.',
            'course_other.required_if' => 'يرجى كتابة اسم الدورة.',
            'rating.required' => 'يرجى اختيار التقييم.',
            'quote.required' => 'يرجى كتابة رأيك.',
            'quote.min' => 'يجب أن يكون الرأي 20 حرفاً على الأقل.',
            'consent.accepted' => 'يجب الموافقة على شروط النشر.',
        ]);

        $courseName = $validated['course_name'] === 'other'
            ? ($validated['course_other'] ?? 'دورة أخرى')
            : $validated['course_name'];

        $data = [
            'student_name' => $validated['student_name'],
            'student_email' => $validated['student_email'] ?? null,
            'student_title' => $validated['student_title'] ?? null,
            'course_name' => $courseName,
            'rating' => $validated['rating'],
            'quote' => $validated['quote'],
            'status' => Testimonial::STATUS_PENDING,
            'is_active' => false,
            'is_featured' => false,
            'is_public_submission' => true,
            'order' => 0,
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('testimonials.submit')
            ->with('success', 'شكراً لك! تم استلام رأيك وسيُراجع من الإدارة قبل النشر.');
    }
}
