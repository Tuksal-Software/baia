<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display review list
     */
    public function index(Request $request): View
    {
        $query = Review::with('product');

        // Filter by status
        if ($request->filled('status')) {
            match ($request->status) {
                'pending' => $query->pending(),
                'approved' => $query->approved(),
                default => null,
            };
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(20)->withQueryString();

        // Status counts
        $pendingCount = Review::pending()->count();
        $approvedCount = Review::approved()->count();

        return view('admin.reviews.index', compact('reviews', 'pendingCount', 'approvedCount'));
    }

    /**
     * Show review details
     */
    public function show(Review $review): View
    {
        $review->load('product');

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve review
     */
    public function approve(Review $review): RedirectResponse
    {
        $review->approve();

        return redirect()->back()
            ->with('success', 'Yorum onaylandı.');
    }

    /**
     * Reject review
     */
    public function reject(Review $review): RedirectResponse
    {
        $review->reject();

        return redirect()->back()
            ->with('success', 'Yorum reddedildi.');
    }

    /**
     * Toggle verified status
     */
    public function toggleVerified(Review $review): RedirectResponse
    {
        $review->is_verified = !$review->is_verified;
        $review->save();

        $status = $review->is_verified ? 'doğrulandı' : 'doğrulama kaldırıldı';

        return redirect()->back()
            ->with('success', "Yorum {$status}.");
    }

    /**
     * Delete review
     */
    public function destroy(Review $review): RedirectResponse
    {
        $product = $review->product;
        $review->delete();

        // Update product rating
        $product->updateRating();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Yorum silindi.');
    }

    /**
     * Bulk approve reviews
     */
    public function bulkApprove(Request $request): RedirectResponse
    {
        $request->validate([
            'reviews' => 'required|array',
            'reviews.*' => 'exists:reviews,id',
        ]);

        $reviews = Review::whereIn('id', $request->reviews)->get();

        foreach ($reviews as $review) {
            $review->approve();
        }

        return redirect()->back()
            ->with('success', 'Seçili yorumlar onaylandı.');
    }

    /**
     * Bulk delete reviews
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'reviews' => 'required|array',
            'reviews.*' => 'exists:reviews,id',
        ]);

        $reviews = Review::whereIn('id', $request->reviews)->get();
        $productIds = $reviews->pluck('product_id')->unique();

        Review::whereIn('id', $request->reviews)->delete();

        // Update ratings for affected products
        foreach ($productIds as $productId) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $product->updateRating();
            }
        }

        return redirect()->back()
            ->with('success', 'Seçili yorumlar silindi.');
    }
}
