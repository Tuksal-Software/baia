<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all products
     */
    public function index(): View
    {
        $products = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Display product detail
     */
    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'category.parent',
            'images' => fn($q) => $q->ordered(),
            'specifications' => fn($q) => $q->ordered(),
            'features' => fn($q) => $q->ordered(),
            'variants' => fn($q) => $q->active(),
            'approvedReviews' => fn($q) => $q->take(10),
        ]);

        // Related products (same category)
        $relatedProducts = Product::with(['primaryImage', 'variants'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display featured products
     */
    public function featured(): View
    {
        $products = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->featured()
            ->paginate(12);

        return view('products.featured', compact('products'));
    }

    /**
     * Display new products
     */
    public function new(): View
    {
        $products = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->new()
            ->paginate(12);

        return view('products.new', compact('products'));
    }

    /**
     * Display products on sale
     */
    public function sale(): View
    {
        $products = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->onSale()
            ->paginate(12);

        return view('products.sale', compact('products'));
    }
}
