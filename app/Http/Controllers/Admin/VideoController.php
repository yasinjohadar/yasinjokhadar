<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::query();

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

        $videos = $query->orderBy('order')->orderByDesc('id')->paginate(15);

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|url|max:500',
            'thumbnail' => 'nullable|image|max:2048',
            'views_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
            'is_featured' => 'nullable|in:0,1',
        ], [
            'title.required' => 'عنوان الفيديو مطلوب.',
            'video_url.required' => 'رابط يوتيوب مطلوب.',
            'video_url.url' => 'رابط يوتيوب غير صالح.',
        ]);

        $validated['views_count'] = (int) ($validated['views_count'] ?? 0);
        $validated['order'] = (int) ($validated['order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'تم إضافة الفيديو بنجاح.');
    }

    public function show(Video $video)
    {
        return redirect()->route('admin.videos.edit', $video);
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|string|url|max:500',
            'thumbnail' => 'nullable|image|max:2048',
            'views_count' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|in:0,1',
            'is_featured' => 'nullable|in:0,1',
        ], [
            'title.required' => 'عنوان الفيديو مطلوب.',
            'video_url.required' => 'رابط يوتيوب مطلوب.',
            'video_url.url' => 'رابط يوتيوب غير صالح.',
        ]);
        $validated['views_count'] = (int) ($validated['views_count'] ?? $video->views_count);
        $validated['order'] = (int) ($validated['order'] ?? $video->order);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'تم تحديث الفيديو بنجاح.');
    }

    public function destroy(Video $video)
    {
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'تم حذف الفيديو بنجاح.');
    }
}
