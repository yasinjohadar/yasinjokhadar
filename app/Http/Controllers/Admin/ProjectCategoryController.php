<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = ProjectCategory::query();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('order')->orderBy('name')->paginate(15);

        return view('admin.projects.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        ProjectCategory::create($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'تم إنشاء تصنيف المشروع بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectCategory $projectCategory)
    {
        return view('admin.projects.categories.edit', [
            'category' => $projectCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectCategory $projectCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $projectCategory->update($validated);

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'تم تحديث تصنيف المشروع بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectCategory $projectCategory)
    {
        if ($projectCategory->projects()->exists()) {
            return redirect()->route('admin.project-categories.index')
                ->with('error', 'لا يمكن حذف تصنيف يحتوي على مشاريع. برجاء نقل المشاريع أولاً.');
        }

        $projectCategory->delete();

        return redirect()->route('admin.project-categories.index')
            ->with('success', 'تم حذف تصنيف المشروع بنجاح.');
    }
}
