<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display menu list
     */
    public function index(): View
    {
        $menus = Menu::with(['items' => function ($query) {
            $query->whereNull('parent_id')->orderBy('order')->with('children');
        }])->get();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show edit form for a menu
     */
    public function edit(Menu $menu): View
    {
        $menu->load(['items' => function ($query) {
            $query->whereNull('parent_id')->orderBy('order')->with(['children' => function ($q) {
                $q->orderBy('order');
            }]);
        }]);

        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update menu items
     */
    public function updateItems(Request $request, Menu $menu): RedirectResponse
    {
        $request->validate([
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:menu_items,id',
            'items.*.title' => 'required|string|max:255',
            'items.*.link' => 'nullable|string|max:255',
            'items.*.target' => 'required|in:_self,_blank',
            'items.*.icon' => 'nullable|string|max:50',
            'items.*.order' => 'required|integer|min:0',
            'items.*.is_active' => 'boolean',
            'items.*.children' => 'nullable|array',
        ]);

        // Delete existing items not in the update
        $existingIds = collect($request->items)->pluck('id')->filter()->toArray();
        $menu->items()->whereNotIn('id', $existingIds)->delete();

        // Update or create items
        $this->saveMenuItems($menu, $request->items);

        Menu::clearCache();

        return redirect()->route('admin.menus.edit', $menu)
            ->with('success', __('Menu updated successfully.'));
    }

    /**
     * Save menu items recursively
     */
    private function saveMenuItems(Menu $menu, array $items, ?int $parentId = null): void
    {
        foreach ($items as $itemData) {
            $data = [
                'menu_id' => $menu->id,
                'parent_id' => $parentId,
                'title' => $itemData['title'],
                'link' => $itemData['link'] ?? null,
                'target' => $itemData['target'] ?? '_self',
                'icon' => $itemData['icon'] ?? null,
                'order' => $itemData['order'] ?? 0,
                'is_active' => isset($itemData['is_active']) ? (bool) $itemData['is_active'] : true,
            ];

            if (!empty($itemData['id'])) {
                $item = MenuItem::find($itemData['id']);
                if ($item) {
                    $item->update($data);
                } else {
                    $item = MenuItem::create($data);
                }
            } else {
                $item = MenuItem::create($data);
            }

            // Handle children
            if (!empty($itemData['children'])) {
                // Delete children not in the update
                $childIds = collect($itemData['children'])->pluck('id')->filter()->toArray();
                $item->children()->whereNotIn('id', $childIds)->delete();

                $this->saveMenuItems($menu, $itemData['children'], $item->id);
            } else {
                // Delete all children if none provided
                $item->children()->delete();
            }
        }
    }

    /**
     * Add new menu item (AJAX)
     */
    public function addItem(Request $request, Menu $menu): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'target' => 'required|in:_self,_blank',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:menu_items,id',
        ]);

        $validated['menu_id'] = $menu->id;
        $validated['order'] = MenuItem::where('menu_id', $menu->id)
            ->where('parent_id', $validated['parent_id'] ?? null)
            ->max('order') + 1;
        $validated['is_active'] = true;

        $item = MenuItem::create($validated);

        Menu::clearCache();

        return response()->json([
            'success' => true,
            'item' => $item,
        ]);
    }

    /**
     * Delete menu item
     */
    public function deleteItem(MenuItem $item): JsonResponse
    {
        $item->delete();

        Menu::clearCache();

        return response()->json(['success' => true]);
    }

    /**
     * Update menu item order (AJAX)
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menu_items,id',
            'items.*.order' => 'required|integer|min:0',
            'items.*.parent_id' => 'nullable|exists:menu_items,id',
        ]);

        foreach ($request->items as $item) {
            MenuItem::where('id', $item['id'])->update([
                'order' => $item['order'],
                'parent_id' => $item['parent_id'] ?? null,
            ]);
        }

        Menu::clearCache();

        return response()->json(['success' => true]);
    }
}
