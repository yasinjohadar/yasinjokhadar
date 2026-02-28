<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectFeature;
use App\Models\ProjectImage;
use App\Models\ProjectVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Project::with('category');

        if (request()->filled('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if (request()->filled('category')) {
            $query->where('project_category_id', request('category'));
        }

        $projects = $query->orderBy('order')->orderBy('title')->paginate(15);
        $categories = ProjectCategory::orderBy('order')->orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ProjectCategory::orderBy('order')->orderBy('name')->get();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_category_id' => 'required|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'code_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create($validated);

        $this->syncFeatures($project, $request->input('features', []));
        $this->syncVideos($project, $request->input('videos', []));
        $this->attachGalleryImages($project, $request->file('gallery', []), $request->input('gallery_captions', []));

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم إنشاء المشروع بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return redirect()->route('projects.show', $project->slug);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->load(['images', 'videos', 'features']);
        $categories = ProjectCategory::orderBy('order')->orderBy('name')->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'project_category_id' => 'required|exists:project_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'code_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        $this->syncFeatures($project, $request->input('features', []));
        $this->syncVideos($project, $request->input('videos', []));
        $this->syncGalleryImages($project, $request->input('existing_images', []), $request->file('gallery', []), $request->input('gallery_captions', []));

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم تحديث المشروع بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        foreach ($project->images as $img) {
            Storage::disk('public')->delete($img->image);
        }
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم حذف المشروع بنجاح.');
    }

    protected function syncFeatures(Project $project, array $items): void
    {
        $project->features()->delete();
        $order = 0;
        foreach ($items as $item) {
            if (empty($item['title'])) {
                continue;
            }
            $project->features()->create([
                'title' => $item['title'],
                'description' => $item['description'] ?? null,
                'icon' => $item['icon'] ?? null,
                'order' => $order++,
            ]);
        }
    }

    protected function syncVideos(Project $project, array $items): void
    {
        $project->videos()->delete();
        $order = 0;
        foreach ($items as $item) {
            if (empty($item['url'])) {
                continue;
            }
            $project->videos()->create([
                'url' => $item['url'],
                'title' => $item['title'] ?? null,
                'order' => $order++,
            ]);
        }
    }

    protected function attachGalleryImages(Project $project, array $files, array $captions): void
    {
        $order = $project->images()->max('order') ?? -1;
        foreach ($files as $i => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            $path = $file->store('projects/gallery', 'public');
            $project->images()->create([
                'image' => $path,
                'caption' => $captions[$i] ?? null,
                'order' => ++$order,
            ]);
        }
    }

    protected function syncGalleryImages(Project $project, array $existing, array $newFiles, array $newCaptions): void
    {
        $keepIds = [];
        foreach ($existing as $i => $item) {
            $id = (int) ($item['id'] ?? 0);
            if (!empty($item['delete']) && $id) {
                $img = $project->images()->find($id);
                if ($img) {
                    Storage::disk('public')->delete($img->image);
                    $img->delete();
                }
                continue;
            }
            if ($id) {
                $img = $project->images()->find($id);
                if ($img) {
                    $img->update([
                        'caption' => $item['caption'] ?? null,
                        'order' => (int) ($item['order'] ?? $i),
                    ]);
                    $keepIds[] = $id;
                }
            }
        }
        $project->images()->whereNotIn('id', $keepIds)->each(function (ProjectImage $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        });
        $startOrder = $project->images()->max('order') ?? -1;
        foreach ($newFiles as $i => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }
            $path = $file->store('projects/gallery', 'public');
            $project->images()->create([
                'image' => $path,
                'caption' => $newCaptions[$i] ?? null,
                'order' => ++$startOrder,
            ]);
        }
    }
}
