<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'pending_reviews' => Review::pending()->count(),
            'active_discount_codes' => DiscountCode::active()->count(),
        ];

        // Recent orders
        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        // Orders by status
        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Revenue stats (last 30 days)
        $revenueStats = Order::where('status', '!=', Order::STATUS_CANCELLED)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top products (by order count)
        $topProducts = Product::withCount(['variants'])
            ->withSum('variants', 'stock')
            ->orderBy('reviews_count', 'desc')
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = Product::active()
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'ordersByStatus',
            'revenueStats',
            'topProducts',
            'lowStockProducts'
        ));
    }
}
