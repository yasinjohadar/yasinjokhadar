<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index(Request $request)
    {
        $query = GalleryImage::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('featured')) {
            if ($request->featured === 'yes') {
                $query->where('is_featured', true);
            } elseif ($request->featured === 'no') {
                $query->where('is_featured', false);
            }
        }

        $images = $query->orderBy('order')->orderByDesc('id')->paginate(15);

        return view('admin.gallery-images.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery-images.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:4096',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
        ], [
            'title.required' => 'يرجى إدخال عنوان الصورة.',
            'image.required' => 'يرجى اختيار صورة للمعرض.',
            'image.image' => 'الملف المرفوع يجب أن يكون صورة (jpg, png, gif, webp).',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 4 ميجابايت.',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        $validated['image'] = $request->file('image')->store('gallery', 'public');

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'تم إضافة الصورة بنجاح.');
    }

    public function show(GalleryImage $galleryImage)
    {
        return redirect()->route('admin.gallery-images.edit', $galleryImage);
    }

    public function edit(GalleryImage $galleryImage)
    {
        return view('admin.gallery-images.edit', compact('galleryImage'));
    }

    public function update(Request $request, GalleryImage $galleryImage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? $galleryImage->order);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($galleryImage->image) {
                Storage::disk('public')->delete($galleryImage->image);
            }
            $validated['image'] = $request->file('image')->store('gallery', 'public');
        }

        $galleryImage->update($validated);

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'تم تحديث الصورة بنجاح.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        if ($galleryImage->image) {
            Storage::disk('public')->delete($galleryImage->image);
        }

        $galleryImage->delete();

        return redirect()->route('admin.gallery-images.index')
            ->with('success', 'تم حذف الصورة بنجاح.');
    }
}
