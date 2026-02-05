<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display category list
     */
    public function index(): View
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->orderBy('order')
            ->get();

        // Group by parent for tree view
        $rootCategories = $categories->whereNull('parent_id');

        return view('admin.categories.index', compact('categories', 'rootCategories'));
    }

    /**
     * Show create form
     */
    public function create(): View
    {
        $parentCategories = Category::root()->active()->ordered()->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store new category
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $request->input('order', 0);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    /**
     * Show edit form
     */
    public function edit(Category $category): View
    {
        $parentCategories = Category::root()
            ->where('id', '!=', $category->id)
            ->active()
            ->ordered()
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update category
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Prevent setting itself as parent
        if ($validated['parent_id'] == $category->id) {
            return redirect()->back()
                ->with('error', 'Kategori kendisinin üst kategorisi olamaz.');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    /**
     * Delete category
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Check if category has products
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Bu kategoride ürünler var. Önce ürünleri başka kategoriye taşıyın.');
        }

        // Check if category has children
        if ($category->children()->exists()) {
            return redirect()->back()
                ->with('error', 'Bu kategorinin alt kategorileri var. Önce alt kategorileri silin.');
        }

        // Delete image
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }

    /**
     * Update category order (AJAX)
     */
    public function updateOrder(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:categories,id',
            'categories.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->categories as $item) {
            Category::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->is_active = !$category->is_active;
        $category->save();

        $status = $category->is_active ? 'aktif' : 'pasif';

        return redirect()->back()
            ->with('success', "Kategori {$status} yapıldı.");
    }
}
