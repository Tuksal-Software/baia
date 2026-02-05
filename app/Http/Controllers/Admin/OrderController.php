<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display order list
     */
    public function index(Request $request): View
    {
        $query = Order::with('items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        // Status counts for tabs
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Show order details
     */
    public function show(Order $order): View
    {
        $order->load(['items.product', 'items.variant']);

        $whatsappNumber = config('app.whatsapp_number', '+905551234567');
        $whatsappUrl = $order->getWhatsAppUrl($whatsappNumber);

        return view('admin.orders.show', compact('order', 'whatsappUrl'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->updateStatus($request->status);

        // Set confirmed_at if confirming
        if ($request->status === Order::STATUS_CONFIRMED && $oldStatus === Order::STATUS_PENDING) {
            $order->confirmed_at = now();
            $order->save();
        }

        return redirect()->back()
            ->with('success', 'Sipariş durumu güncellendi.');
    }

    /**
     * Add note to order
     */
    public function addNote(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'notes' => 'required|string|max:2000',
        ]);

        $currentNotes = $order->notes ?? '';
        $newNote = "[" . now()->format('d.m.Y H:i') . "] " . $request->notes;

        $order->notes = $currentNotes ? $currentNotes . "\n\n" . $newNote : $newNote;
        $order->save();

        return redirect()->back()
            ->with('success', 'Not eklendi.');
    }

    /**
     * Confirm order
     */
    public function confirm(Order $order): RedirectResponse
    {
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->back()
                ->with('error', 'Bu sipariş zaten onaylanmış veya iptal edilmiş.');
        }

        $order->confirm();

        return redirect()->back()
            ->with('success', 'Sipariş onaylandı.');
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order): RedirectResponse
    {
        if (in_array($order->status, [Order::STATUS_DELIVERED, Order::STATUS_CANCELLED])) {
            return redirect()->back()
                ->with('error', 'Bu sipariş iptal edilemez.');
        }

        $order->cancel();

        return redirect()->back()
            ->with('success', 'Sipariş iptal edildi.');
    }

    /**
     * Export orders
     */
    public function export(Request $request)
    {
        $query = Order::with('items');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        // Generate CSV
        $filename = 'siparisler_' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header row
            fputcsv($file, [
                'Sipariş No',
                'Tarih',
                'Müşteri Adı',
                'E-posta',
                'Telefon',
                'Adres',
                'Ürünler',
                'Ara Toplam',
                'İndirim',
                'Toplam',
                'Durum',
                'Notlar',
            ], ';');

            foreach ($orders as $order) {
                $products = $order->items->map(function ($item) {
                    return $item->display_name . ' x' . $item->quantity;
                })->implode(', ');

                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('d.m.Y H:i'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->customer_address,
                    $products,
                    number_format($order->subtotal, 2, ',', '.'),
                    number_format($order->discount, 2, ',', '.'),
                    number_format($order->total, 2, ',', '.'),
                    $order->status_label,
                    str_replace("\n", ' | ', $order->notes ?? ''),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'orders' => 'required|array',
            'orders.*' => 'exists:orders,id',
        ]);

        Order::whereIn('id', $request->orders)->update([
            'status' => $request->status,
            'confirmed_at' => $request->status === Order::STATUS_CONFIRMED ? now() : null,
        ]);

        return redirect()->back()
            ->with('success', 'Siparişler güncellendi.');
    }
}
