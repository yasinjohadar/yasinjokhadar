<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Testimonial::query();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('course_name', 'like', "%{$search}%");
            });
        }

        if (request()->filled('approval')) {
            $query->where('status', request('approval'));
        }

        if (request()->filled('status')) {
            $status = request('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if (request()->filled('source')) {
            if (request('source') === 'public') {
                $query->where('is_public_submission', true);
            } elseif (request('source') === 'admin') {
                $query->where('is_public_submission', false);
            }
        }

        if (request()->filled('featured')) {
            $featured = request('featured');
            if ($featured === 'yes') {
                $query->where('is_featured', true);
            } elseif ($featured === 'no') {
                $query->where('is_featured', false);
            }
        }

        $testimonials = $query->orderBy('order')->orderByDesc('id')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_title' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'required|string',
            'avatar' => 'nullable|image|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['rating'] = $validated['rating'] ?? 5;
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['status'] = Testimonial::STATUS_APPROVED;
        $validated['is_public_submission'] = false;

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم إضافة رأي الطالب بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return redirect()->route('admin.testimonials.edit', $testimonial);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_title' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'required|string',
            'avatar' => 'nullable|image|max:2048',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['rating'] = $validated['rating'] ?? $testimonial->rating ?? 5;
        $validated['order'] = $validated['order'] ?? $testimonial->order ?? 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم تحديث رأي الطالب بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم حذف رأي الطالب بنجاح.');
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => Testimonial::STATUS_APPROVED,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'تم قبول الرأي ونشره بنجاح.');
    }

    public function reject(Testimonial $testimonial)
    {
        $testimonial->update([
            'status' => Testimonial::STATUS_REJECTED,
            'is_active' => false,
            'is_featured' => false,
        ]);

        return redirect()->back()->with('success', 'تم رفض الرأي.');
    }
}
