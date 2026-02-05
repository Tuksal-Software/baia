<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $product->id)
            ->where('customer_email', $request->customer_email)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'Bu ürün için zaten bir değerlendirme yapmışsınız.');
        }

        Review::create([
            'product_id' => $product->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified' => false,
            'is_approved' => false, // Requires admin approval
        ]);

        return redirect()->back()
            ->with('success', 'Değerlendirmeniz alındı. Onaylandıktan sonra yayınlanacaktır.');
    }
}
