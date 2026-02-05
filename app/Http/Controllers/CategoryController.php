<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index(): View
    {
        $categories = Category::with(['children' => function ($query) {
            $query->active()->ordered()->withCount('products');
        }])
            ->active()
            ->root()
            ->ordered()
            ->withCount('products')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display category with products
     */
    public function show(Request $request, Category $category): View
    {
        abort_unless($category->is_active, 404);

        // Get category IDs (include children)
        $categoryIds = collect([$category->id]);
        if ($category->hasChildren()) {
            $categoryIds = $categoryIds->merge(
                $category->children()->active()->pluck('id')
            );
        }

        // Build products query
        $query = Product::with(['category', 'primaryImage', 'variants'])
            ->active()
            ->whereIn('category_id', $categoryIds);

        // Apply filters
        if ($request->filled('min_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '>=', $request->min_price)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('sale_price')
                            ->where('price', '>=', $request->min_price);
                    });
            });
        }

        if ($request->filled('max_price')) {
            $query->where(function ($q) use ($request) {
                $q->where('sale_price', '<=', $request->max_price)
                    ->orWhere(function ($q2) use ($request) {
                        $q2->whereNull('sale_price')
                            ->where('price', '<=', $request->max_price);
                    });
            });
        }

        if ($request->boolean('on_sale')) {
            $query->onSale();
        }

        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Apply sorting
        $sort = $request->get('sort', 'newest');
        $query = match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            'rating' => $query->orderBy('rating', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate(12)->withQueryString();

        // Get subcategories
        $subcategories = $category->children()->active()->ordered()->withCount('products')->get();

        // Price range for filter
        $priceRange = Product::active()
            ->whereIn('category_id', $categoryIds)
            ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price, MAX(COALESCE(sale_price, price)) as max_price')
            ->first();

        return view('categories.show', compact(
            'category',
            'products',
            'subcategories',
            'priceRange'
        ));
    }
}
