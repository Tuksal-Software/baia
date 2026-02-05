<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    use HandlesFileUploads;

    public function index(): View
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->orderBy('order')
            ->get();

        $rootCategories = $categories->whereNull('parent_id');

        return view('admin.categories.index', compact('categories', 'rootCategories'));
    }

    public function create(): View
    {
        $parentCategories = Category::root()->active()->ordered()->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.tr' => 'required|string|max:255',
            'name.en' => 'nullable|string|max:255',
            'name.de' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']['tr'] ?? '');
            $slug = $baseSlug;
            $counter = 1;

            while (Category::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'categories');
        }

        Category::create([
            'name' => array_filter($validated['name']),
            'slug' => $validated['slug'],
            'parent_id' => $validated['parent_id'] ?? null,
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'image' => $imagePath,
            'order' => $request->input('order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::root()
            ->where('id', '!=', $category->id)
            ->active()
            ->ordered()
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|array',
            'name.tr' => 'required|string|max:255',
            'name.en' => 'nullable|string|max:255',
            'name.de' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|array',
            'description.*' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if (($validated['parent_id'] ?? null) == $category->id) {
            return redirect()->back()
                ->with('error', 'Kategori kendisinin üst kategorisi olamaz.');
        }

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name']['tr'] ?? '');
            $slug = $baseSlug;
            $counter = 1;

            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        $updateData = [
            'name' => array_filter($validated['name']),
            'slug' => $validated['slug'],
            'parent_id' => $validated['parent_id'] ?? null,
            'description' => isset($validated['description']) ? array_filter($validated['description']) : null,
            'order' => $request->input('order', $category->order),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $this->deleteFile($category->image);
            $updateData['image'] = $this->uploadFile($request->file('image'), 'categories');
        }

        $category->update($updateData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Bu kategoride ürünler var. Önce ürünleri başka kategoriye taşıyın.');
        }

        if ($category->children()->exists()) {
            return redirect()->back()
                ->with('error', 'Bu kategorinin alt kategorileri var. Önce alt kategorileri silin.');
        }

        $this->deleteFile($category->image);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }

    public function updateOrder(Request $request): JsonResponse
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

    public function toggleStatus(Category $category): RedirectResponse
    {
        $category->update(['is_active' => !$category->is_active]);
        $status = $category->is_active ? 'aktif' : 'pasif';

        return redirect()->back()->with('success', "Kategori {$status} yapıldı.");
    }
}
