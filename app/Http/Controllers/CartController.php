<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Get or create cart
     */
    protected function getCart(): Cart
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        return Cart::getBySession($sessionId, $userId);
    }

    /**
     * Display cart
     */
    public function index(): View
    {
        $cart = $this->getCart();
        $cart->load(['items.product.primaryImage', 'items.variant']);

        // Refresh prices and check availability
        foreach ($cart->items as $item) {
            if (!$item->is_available) {
                session()->flash('warning', "'{$item->display_name}' ürünü artık mevcut değil veya stok yetersiz.");
            }
        }

        return view('cart.index', compact('cart'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return $this->respondError('Bu ürün artık mevcut değil.');
        }

        $variant = null;
        if ($request->variant_id) {
            $variant = ProductVariant::findOrFail($request->variant_id);
            if (!$variant->is_active || $variant->product_id !== $product->id) {
                return $this->respondError('Seçilen varyant mevcut değil.');
            }
        }

        $quantity = $request->input('quantity', 1);

        // Check stock
        $availableStock = $variant ? $variant->stock : $product->stock;
        if ($availableStock < $quantity) {
            return $this->respondError('Yeterli stok bulunmuyor.');
        }

        $cart = $this->getCart();
        $cart->addItem($product, $quantity, $variant);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ürün sepete eklendi.',
                'cart_count' => $cart->fresh()->total_items,
            ]);
        }

        return redirect()->back()->with('success', 'Ürün sepete eklendi.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $cart = $this->getCart();

        // Verify item belongs to this cart
        if ($cartItem->cart_id !== $cart->id) {
            return $this->respondError('Bu ürün sepetinizde bulunamadı.');
        }

        $quantity = $request->quantity;

        if ($quantity === 0) {
            $cart->removeItem($cartItem);
            $message = 'Ürün sepetten kaldırıldı.';
        } else {
            // Check stock
            $availableStock = $cartItem->variant ? $cartItem->variant->stock : $cartItem->product->stock;
            if ($availableStock < $quantity) {
                return $this->respondError('Yeterli stok bulunmuyor.');
            }

            $cart->updateItemQuantity($cartItem, $quantity);
            $message = 'Sepet güncellendi.';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $cart->fresh()->total_items,
                'cart_subtotal' => number_format($cart->fresh()->subtotal, 2),
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $cart = $this->getCart();

        // Verify item belongs to this cart
        if ($cartItem->cart_id !== $cart->id) {
            return $this->respondError('Bu ürün sepetinizde bulunamadı.');
        }

        $cart->removeItem($cartItem);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ürün sepetten kaldırıldı.',
                'cart_count' => $cart->fresh()->total_items,
            ]);
        }

        return redirect()->back()->with('success', 'Ürün sepetten kaldırıldı.');
    }

    /**
     * Clear cart
     */
    public function clear(): RedirectResponse
    {
        $cart = $this->getCart();
        $cart->clear();

        return redirect()->route('cart.index')->with('success', 'Sepet temizlendi.');
    }

    /**
     * Apply discount code
     */
    public function applyDiscount(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = DiscountCode::findByCode($request->code);

        if (!$code) {
            return $this->respondError('Geçersiz indirim kodu.');
        }

        $cart = $this->getCart();
        $error = $code->getValidationError($cart->subtotal);

        if ($error) {
            return $this->respondError($error);
        }

        // Store discount code in session
        session(['discount_code' => $code->code]);

        $discount = $code->calculateDiscount($cart->subtotal);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'İndirim kodu uygulandı.',
                'discount' => number_format($discount, 2),
                'total' => number_format($cart->subtotal - $discount, 2),
            ]);
        }

        return redirect()->back()->with('success', 'İndirim kodu uygulandı.');
    }

    /**
     * Remove discount code
     */
    public function removeDiscount(): RedirectResponse
    {
        session()->forget('discount_code');

        return redirect()->back()->with('success', 'İndirim kodu kaldırıldı.');
    }

    /**
     * Get cart data (AJAX)
     */
    public function getData(): JsonResponse
    {
        $cart = $this->getCart();
        $cart->load(['items.product.primaryImage', 'items.variant']);

        $discountCode = session('discount_code');
        $discount = 0;

        if ($discountCode) {
            $code = DiscountCode::findByCode($discountCode);
            if ($code && $code->isValid($cart->subtotal)) {
                $discount = $code->calculateDiscount($cart->subtotal);
            } else {
                session()->forget('discount_code');
                $discountCode = null;
            }
        }

        return response()->json([
            'items' => $cart->items->map(fn($item) => [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'name' => $item->display_name,
                'image' => $item->product->primaryImage?->image_path,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'total' => $item->total,
                'is_available' => $item->is_available,
            ]),
            'total_items' => $cart->total_items,
            'subtotal' => $cart->subtotal,
            'discount_code' => $discountCode,
            'discount' => $discount,
            'total' => $cart->subtotal - $discount,
        ]);
    }

    /**
     * Return error response
     */
    protected function respondError(string $message): RedirectResponse|JsonResponse
    {
        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return redirect()->back()->with('error', $message);
    }
}
