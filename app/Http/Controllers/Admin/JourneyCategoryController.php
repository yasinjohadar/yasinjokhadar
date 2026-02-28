<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JourneyCategory;
use Illuminate\Http\Request;

class JourneyCategoryController extends Controller
{
    public function index()
    {
        $query = JourneyCategory::query();

        if (request()->filled('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('order')->orderBy('name')->paginate(15);

        return view('admin.journey.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.journey.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        JourneyCategory::create($validated);

        return redirect()->route('admin.journey-categories.index')
            ->with('success', 'تم إضافة تصنيف المسيرة بنجاح.');
    }

    public function edit(JourneyCategory $journeyCategory)
    {
        return view('admin.journey.categories.edit', compact('journeyCategory'));
    }

    public function update(Request $request, JourneyCategory $journeyCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? $journeyCategory->order);
        $validated['is_active'] = $request->boolean('is_active');

        $journeyCategory->update($validated);

        return redirect()->route('admin.journey-categories.index')
            ->with('success', 'تم تحديث تصنيف المسيرة بنجاح.');
    }

    public function destroy(JourneyCategory $journeyCategory)
    {
        if ($journeyCategory->milestones()->exists()) {
            return redirect()->route('admin.journey-categories.index')
                ->with('error', 'لا يمكن حذف تصنيف يحتوي على محطات. برجاء حذف المحطات أولاً أو نقلها.');
        }

        $journeyCategory->delete();

        return redirect()->route('admin.journey-categories.index')
            ->with('success', 'تم حذف تصنيف المسيرة بنجاح.');
    }
}
