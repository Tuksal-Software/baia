<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFeature;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display product list
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'primaryImage'])
            ->withCount('variants');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $query->active(),
                'inactive' => $query->where('is_active', false),
                'featured' => $query->featured(),
                'on_sale' => $query->onSale(),
                'low_stock' => $query->where('stock', '<=', 5),
                default => null,
            };
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $categories = Category::with('children')
            ->active()
            ->ordered()
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100|unique:products,sku',
            'stock' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            // Images
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            // Specifications
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required_with:specifications|string|max:100',
            'specifications.*.value' => 'required_with:specifications|string|max:255',
            'specifications.*.unit' => 'nullable|string|max:50',
            // Features
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price_difference' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        DB::beginTransaction();

        try {
            // Create product
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'],
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'sku' => $validated['sku'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'is_active' => $request->boolean('is_active', true),
                'is_featured' => $request->boolean('is_featured'),
                'is_new' => $request->boolean('is_new'),
            ]);

            // Handle images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'order' => $index,
                        'is_primary' => $index === 0,
                    ]);
                }
            }

            // Handle specifications
            if (!empty($validated['specifications'])) {
                foreach ($validated['specifications'] as $index => $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'key' => $spec['key'],
                            'value' => $spec['value'],
                            'unit' => $spec['unit'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            // Handle features
            if (!empty($validated['features'])) {
                foreach ($validated['features'] as $index => $feature) {
                    if (!empty($feature)) {
                        ProductFeature::create([
                            'product_id' => $product->id,
                            'feature' => $feature,
                            'order' => $index,
                        ]);
                    }
                }
            }

            // Handle variants
            if (!empty($validated['variants'])) {
                foreach ($validated['variants'] as $variant) {
                    if (!empty($variant['name'])) {
                        ProductVariant::create([
                            'product_id' => $product->id,
                            'name' => $variant['name'],
                            'sku' => $variant['sku'] ?? null,
                            'price_difference' => $variant['price_difference'] ?? 0,
                            'stock' => $variant['stock'] ?? 0,
                            'is_active' => true,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Ürün başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Ürün oluşturulurken bir hata oluştu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show product details
     */
    public function show(Product $product): View
    {
        $product->load([
            'category',
            'images',
            'specifications',
            'features',
            'variants',
            'reviews' => fn($q) => $q->latest()->take(10),
        ]);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show edit form
     */
    public function edit(Product $product): View
    {
        $product->load(['images', 'specifications', 'features', 'variants']);

        $categories = Category::with('children')
            ->active()
            ->ordered()
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $product->id,
            'stock' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_new' => 'boolean',
            // New images
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            // Specifications
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required_with:specifications|string|max:100',
            'specifications.*.value' => 'required_with:specifications|string|max:255',
            'specifications.*.unit' => 'nullable|string|max:50',
            // Features
            'features' => 'nullable|array',
            'features.*' => 'string|max:255',
            // Variants
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.sku' => 'nullable|string|max:100',
            'variants.*.price_difference' => 'nullable|numeric',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        DB::beginTransaction();

        try {
            // Update product
            $product->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'],
                'short_description' => $validated['short_description'] ?? null,
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'sale_price' => $validated['sale_price'] ?? null,
                'sku' => $validated['sku'] ?? null,
                'stock' => $validated['stock'] ?? 0,
                'is_active' => $request->boolean('is_active'),
                'is_featured' => $request->boolean('is_featured'),
                'is_new' => $request->boolean('is_new'),
            ]);

            // Handle new images
            if ($request->hasFile('images')) {
                $maxOrder = $product->images()->max('order') ?? -1;
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'order' => $maxOrder + $index + 1,
                        'is_primary' => !$product->images()->exists(),
                    ]);
                }
            }

            // Update specifications (delete and recreate)
            $product->specifications()->delete();
            if (!empty($validated['specifications'])) {
                foreach ($validated['specifications'] as $index => $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'key' => $spec['key'],
                            'value' => $spec['value'],
                            'unit' => $spec['unit'] ?? null,
                            'order' => $index,
                        ]);
                    }
                }
            }

            // Update features (delete and recreate)
            $product->features()->delete();
            if (!empty($validated['features'])) {
                foreach ($validated['features'] as $index => $feature) {
                    if (!empty($feature)) {
                        ProductFeature::create([
                            'product_id' => $product->id,
                            'feature' => $feature,
                            'order' => $index,
                        ]);
                    }
                }
            }

            // Update variants
            $existingVariantIds = [];
            if (!empty($validated['variants'])) {
                foreach ($validated['variants'] as $variantData) {
                    if (!empty($variantData['name'])) {
                        if (!empty($variantData['id'])) {
                            // Update existing
                            $variant = ProductVariant::find($variantData['id']);
                            if ($variant && $variant->product_id === $product->id) {
                                $variant->update([
                                    'name' => $variantData['name'],
                                    'sku' => $variantData['sku'] ?? null,
                                    'price_difference' => $variantData['price_difference'] ?? 0,
                                    'stock' => $variantData['stock'] ?? 0,
                                    'is_active' => $variantData['is_active'] ?? true,
                                ]);
                                $existingVariantIds[] = $variant->id;
                            }
                        } else {
                            // Create new
                            $variant = ProductVariant::create([
                                'product_id' => $product->id,
                                'name' => $variantData['name'],
                                'sku' => $variantData['sku'] ?? null,
                                'price_difference' => $variantData['price_difference'] ?? 0,
                                'stock' => $variantData['stock'] ?? 0,
                                'is_active' => true,
                            ]);
                            $existingVariantIds[] = $variant->id;
                        }
                    }
                }
            }
            // Delete removed variants
            $product->variants()->whereNotIn('id', $existingVariantIds)->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Ürün başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Ürün güncellenirken bir hata oluştu: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete product
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete(); // Soft delete

        return redirect()->route('admin.products.index')
            ->with('success', 'Ürün başarıyla silindi.');
    }

    /**
     * Delete product image
     */
    public function deleteImage(ProductImage $image): RedirectResponse
    {
        $product = $image->product;

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        // If deleted image was primary, set first remaining as primary
        if ($image->is_primary) {
            $firstImage = $product->images()->first();
            if ($firstImage) {
                $firstImage->update(['is_primary' => true]);
            }
        }

        return redirect()->back()
            ->with('success', 'Resim silindi.');
    }

    /**
     * Set image as primary
     */
    public function setPrimaryImage(ProductImage $image): RedirectResponse
    {
        $image->setAsPrimary();

        return redirect()->back()
            ->with('success', 'Ana resim değiştirildi.');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Ürün {$status} yapıldı.");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product): RedirectResponse
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'öne çıkarıldı' : 'öne çıkarılmaktan kaldırıldı';

        return redirect()->back()
            ->with('success', "Ürün {$status}.");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete,feature,unfeature',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->products);

        match ($request->action) {
            'activate' => $products->update(['is_active' => true]),
            'deactivate' => $products->update(['is_active' => false]),
            'feature' => $products->update(['is_featured' => true]),
            'unfeature' => $products->update(['is_featured' => false]),
            'delete' => $products->delete(),
        };

        return redirect()->back()
            ->with('success', 'Toplu işlem başarıyla uygulandı.');
    }
}
