<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
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

        $partners = $query->orderBy('order')->orderByDesc('id')->paginate(15);

        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,client,training',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:5000',
            'quote' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? 0);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'تم إضافة الشريك/العميل بنجاح.');
    }

    public function show(Partner $partner)
    {
        return redirect()->route('admin.partners.edit', $partner);
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:company,client,training',
            'logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:5000',
            'quote' => 'nullable|string|max:1000',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['order'] = (int) ($validated['order'] ?? $partner->order);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'تم تحديث الشريك/العميل بنجاح.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'تم حذف الشريك/العميل بنجاح.');
    }
}
