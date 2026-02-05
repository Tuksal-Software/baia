<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * WhatsApp phone number (store owner)
     */
    protected string $whatsappNumber;

    public function __construct()
    {
        $this->whatsappNumber = config('app.whatsapp_number', '+905551234567');
    }

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
     * Display checkout page
     */
    public function index(): View|RedirectResponse
    {
        $cart = $this->getCart();
        $cart->load(['items.product.primaryImage', 'items.variant']);

        if ($cart->is_empty) {
            return redirect()->route('cart.index')
                ->with('error', 'Sepetiniz boş. Sipariş vermek için ürün ekleyin.');
        }

        // Check item availability
        foreach ($cart->items as $item) {
            if (!$item->is_available) {
                return redirect()->route('cart.index')
                    ->with('error', "'{$item->display_name}' ürünü artık mevcut değil veya stok yetersiz. Lütfen sepetinizi güncelleyin.");
            }
        }

        // Get discount if applied
        $discountCode = null;
        $discount = 0;

        if (session('discount_code')) {
            $discountCode = DiscountCode::findByCode(session('discount_code'));
            if ($discountCode && $discountCode->isValid($cart->subtotal)) {
                $discount = $discountCode->calculateDiscount($cart->subtotal);
            } else {
                session()->forget('discount_code');
                $discountCode = null;
            }
        }

        $total = $cart->subtotal - $discount;

        return view('checkout.index', compact('cart', 'discountCode', 'discount', 'total'));
    }

    /**
     * Process checkout and redirect to WhatsApp
     */
    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = $this->getCart();
        $cart->load(['items.product', 'items.variant']);

        if ($cart->is_empty) {
            return redirect()->route('cart.index')
                ->with('error', 'Sepetiniz boş.');
        }

        // Check item availability again
        foreach ($cart->items as $item) {
            if (!$item->is_available) {
                return redirect()->route('cart.index')
                    ->with('error', "'{$item->display_name}' ürünü artık mevcut değil. Lütfen sepetinizi güncelleyin.");
            }
        }

        // Get discount code
        $discountCode = null;
        if (session('discount_code')) {
            $discountCode = DiscountCode::findByCode(session('discount_code'));
            if (!$discountCode || !$discountCode->isValid($cart->subtotal)) {
                session()->forget('discount_code');
                $discountCode = null;
            }
        }

        // Create order
        $order = Order::createFromCart($cart, [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
        ], $discountCode);

        // Clear discount code from session
        session()->forget('discount_code');

        // Store order number in session for confirmation page
        session(['last_order' => $order->order_number]);

        // Redirect to confirmation page
        return redirect()->route('checkout.confirmation', $order);
    }

    /**
     * Display order confirmation
     */
    public function confirmation(Order $order): View|RedirectResponse
    {
        // Security: Only show if it's the last order from this session
        if (session('last_order') !== $order->order_number) {
            return redirect()->route('home')
                ->with('error', 'Sipariş bulunamadı.');
        }

        $order->load('items');
        $whatsappUrl = $order->getWhatsAppUrl($this->whatsappNumber);

        return view('checkout.confirmation', compact('order', 'whatsappUrl'));
    }

    /**
     * Redirect to WhatsApp with order details
     */
    public function whatsapp(Order $order): RedirectResponse
    {
        // Security check
        if (session('last_order') !== $order->order_number) {
            return redirect()->route('home')
                ->with('error', 'Sipariş bulunamadı.');
        }

        $whatsappUrl = $order->getWhatsAppUrl($this->whatsappNumber);

        return redirect()->away($whatsappUrl);
    }

    /**
     * Track order status
     */
    public function track(Request $request): View
    {
        $order = null;
        $error = null;

        if ($request->filled('order_number')) {
            $order = Order::with('items')
                ->where('order_number', $request->order_number)
                ->first();

            if (!$order) {
                $error = 'Sipariş bulunamadı. Lütfen sipariş numaranızı kontrol edin.';
            }
        }

        return view('checkout.track', compact('order', 'error'));
    }
}
