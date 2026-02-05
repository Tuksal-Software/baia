<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DiscountCodeController extends Controller
{
    /**
     * Display discount code list
     */
    public function index(Request $request): View
    {
        $query = DiscountCode::query();

        // Filter by status
        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $query->active(),
                'expired' => $query->where('expires_at', '<', now()),
                'inactive' => $query->where('is_active', false),
                default => null,
            };
        }

        // Search
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        $discountCodes = $query->latest()->paginate(20)->withQueryString();

        return view('admin.discount-codes.index', compact('discountCodes'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        return view('admin.discount-codes.create');
    }

    /**
     * Store new discount code
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:50|unique:discount_codes,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        // Validate percentage max value
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return redirect()->back()
                ->with('error', 'Yüzde değeri 100\'den büyük olamaz.')
                ->withInput();
        }

        // Generate code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = strtoupper(Str::random(8));
        } else {
            $validated['code'] = strtoupper($validated['code']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;

        DiscountCode::create($validated);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'İndirim kodu başarıyla oluşturuldu.');
    }

    /**
     * Show discount code details
     */
    public function show(DiscountCode $discountCode): View
    {
        return view('admin.discount-codes.show', compact('discountCode'));
    }

    /**
     * Show edit form
     */
    public function edit(DiscountCode $discountCode): View
    {
        return view('admin.discount-codes.edit', compact('discountCode'));
    }

    /**
     * Update discount code
     */
    public function update(Request $request, DiscountCode $discountCode): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:discount_codes,code,' . $discountCode->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);

        // Validate percentage max value
        if ($validated['type'] === 'percentage' && $validated['value'] > 100) {
            return redirect()->back()
                ->with('error', 'Yüzde değeri 100\'den büyük olamaz.')
                ->withInput();
        }

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['min_order_amount'] = $validated['min_order_amount'] ?? 0;

        $discountCode->update($validated);

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'İndirim kodu başarıyla güncellendi.');
    }

    /**
     * Delete discount code
     */
    public function destroy(DiscountCode $discountCode): RedirectResponse
    {
        $discountCode->delete();

        return redirect()->route('admin.discount-codes.index')
            ->with('success', 'İndirim kodu silindi.');
    }

    /**
     * Toggle discount code status
     */
    public function toggleStatus(DiscountCode $discountCode): RedirectResponse
    {
        $discountCode->is_active = !$discountCode->is_active;
        $discountCode->save();

        $status = $discountCode->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "İndirim kodu {$status} yapıldı.");
    }

    /**
     * Generate random code
     */
    public function generateCode(): \Illuminate\Http\JsonResponse
    {
        $code = strtoupper(Str::random(8));

        // Make sure it's unique
        while (DiscountCode::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        return response()->json(['code' => $code]);
    }

    /**
     * Reset usage count
     */
    public function resetUsage(DiscountCode $discountCode): RedirectResponse
    {
        $discountCode->used_count = 0;
        $discountCode->save();

        return redirect()->back()
            ->with('success', 'Kullanım sayısı sıfırlandı.');
    }
}
