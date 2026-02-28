<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JourneyCategory;
use App\Models\JourneyMilestone;
use Illuminate\Http\Request;

class JourneyMilestoneController extends Controller
{
    public function index(Request $request)
    {
        $query = JourneyMilestone::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('journey_category_id', $request->category);
        }

        $milestones = $query->orderBy('order')->orderBy('year')->paginate(15);
        $categories = JourneyCategory::active()->orderBy('order')->get();

        return view('admin.journey.milestones.index', compact('milestones', 'categories'));
    }

    public function create()
    {
        $categories = JourneyCategory::active()->orderBy('order')->get();
        return view('admin.journey.milestones.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'journey_category_id' => 'required|exists:journey_categories,id',
            'year' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');

        JourneyMilestone::create($validated);

        return redirect()->route('admin.journey-milestones.index')
            ->with('success', 'تم إضافة المحطة بنجاح.');
    }

    public function edit(JourneyMilestone $journeyMilestone)
    {
        $categories = JourneyCategory::active()->orderBy('order')->get();
        return view('admin.journey.milestones.edit', compact('journeyMilestone', 'categories'));
    }

    public function update(Request $request, JourneyMilestone $journeyMilestone)
    {
        $validated = $request->validate([
            'journey_category_id' => 'required|exists:journey_categories,id',
            'year' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? $journeyMilestone->order);
        $validated['is_active'] = $request->boolean('is_active');

        $journeyMilestone->update($validated);

        return redirect()->route('admin.journey-milestones.index')
            ->with('success', 'تم تحديث المحطة بنجاح.');
    }

    public function destroy(JourneyMilestone $journeyMilestone)
    {
        $journeyMilestone->delete();

        return redirect()->route('admin.journey-milestones.index')
            ->with('success', 'تم حذف المحطة بنجاح.');
    }
}
