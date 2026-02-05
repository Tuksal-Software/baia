<?php

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DiscountCodeController as AdminDiscountCodeController;
use App\Http\Controllers\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\Admin\HomeSectionController as AdminHomeSectionController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storage Route (Symlink Alternative)
|--------------------------------------------------------------------------
*/

Route::get('/storage/{path}', function (string $path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    $mimeType = mime_content_type($fullPath);

    return response()->file($fullPath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.serve');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/hakkimizda', [HomeController::class, 'about'])->name('about');
Route::get('/iletisim', [HomeController::class, 'contact'])->name('contact');
Route::get('/arama', [HomeController::class, 'search'])->name('search');

// Newsletter
Route::post('/bulten', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Categories
Route::get('/kategoriler', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/kategori/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Products
Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/urun/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/one-cikan-urunler', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/yeni-urunler', [ProductController::class, 'new'])->name('products.new');
Route::get('/indirimli-urunler', [ProductController::class, 'sale'])->name('products.sale');

// Reviews
Route::post('/urun/{product}/yorum', [ReviewController::class, 'store'])->name('reviews.store');

// Cart
Route::get('/sepet', [CartController::class, 'index'])->name('cart.index');
Route::post('/sepet/ekle', [CartController::class, 'add'])->name('cart.add');
Route::patch('/sepet/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/sepet/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/sepet', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/sepet/indirim', [CartController::class, 'applyDiscount'])->name('cart.apply-discount');
Route::delete('/sepet/indirim', [CartController::class, 'removeDiscount'])->name('cart.remove-discount');
Route::get('/sepet/veri', [CartController::class, 'getData'])->name('cart.data');

// Checkout
Route::get('/siparis', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/siparis', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/siparis/onay/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
Route::get('/siparis/whatsapp/{order}', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');
Route::get('/siparis-takip', [CheckoutController::class, 'track'])->name('checkout.track');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/giris', fn() => view('auth.login'))->name('login');
Route::post('/giris', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');
Route::get('/kayit', [\App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
Route::post('/kayit', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
Route::post('/cikis', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', AdminCategoryController::class);
    Route::post('categories/order', [AdminCategoryController::class, 'updateOrder'])->name('categories.order');
    Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Products
    Route::resource('products', AdminProductController::class);
    Route::delete('products/image/{image}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');
    Route::patch('products/image/{image}/primary', [AdminProductController::class, 'setPrimaryImage'])->name('products.set-primary-image');
    Route::patch('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/note', [AdminOrderController::class, 'addNote'])->name('orders.add-note');
    Route::post('orders/{order}/confirm', [AdminOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('orders/bulk-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-status');

    // Reviews
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{review}', [AdminReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::patch('reviews/{review}/toggle-verified', [AdminReviewController::class, 'toggleVerified'])->name('reviews.toggle-verified');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('reviews/bulk-approve', [AdminReviewController::class, 'bulkApprove'])->name('reviews.bulk-approve');
    Route::post('reviews/bulk-delete', [AdminReviewController::class, 'bulkDelete'])->name('reviews.bulk-delete');

    // Discount Codes
    Route::resource('discount-codes', AdminDiscountCodeController::class);
    Route::patch('discount-codes/{discount_code}/toggle-status', [AdminDiscountCodeController::class, 'toggleStatus'])->name('discount-codes.toggle-status');
    Route::get('discount-codes-generate', [AdminDiscountCodeController::class, 'generateCode'])->name('discount-codes.generate');
    Route::post('discount-codes/{discount_code}/reset-usage', [AdminDiscountCodeController::class, 'resetUsage'])->name('discount-codes.reset-usage');

    // Site Settings
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Sliders
    Route::resource('sliders', AdminSliderController::class);
    Route::post('sliders/order', [AdminSliderController::class, 'updateOrder'])->name('sliders.order');
    Route::patch('sliders/{slider}/toggle-status', [AdminSliderController::class, 'toggleStatus'])->name('sliders.toggle-status');

    // Banners
    Route::resource('banners', AdminBannerController::class);
    Route::post('banners/order', [AdminBannerController::class, 'updateOrder'])->name('banners.order');
    Route::patch('banners/{banner}/toggle-status', [AdminBannerController::class, 'toggleStatus'])->name('banners.toggle-status');

    // Home Sections
    Route::resource('home-sections', AdminHomeSectionController::class);
    Route::post('home-sections/order', [AdminHomeSectionController::class, 'updateOrder'])->name('home-sections.order');
    Route::patch('home-sections/{home_section}/toggle-status', [AdminHomeSectionController::class, 'toggleStatus'])->name('home-sections.toggle-status');

    // Features
    Route::resource('features', AdminFeatureController::class);
    Route::post('features/order', [AdminFeatureController::class, 'updateOrder'])->name('features.order');
    Route::patch('features/{feature}/toggle-status', [AdminFeatureController::class, 'toggleStatus'])->name('features.toggle-status');

    // Menus
    Route::get('menus', [AdminMenuController::class, 'index'])->name('menus.index');
    Route::get('menus/{menu}/edit', [AdminMenuController::class, 'edit'])->name('menus.edit');
    Route::put('menus/{menu}/items', [AdminMenuController::class, 'updateItems'])->name('menus.update-items');
    Route::post('menus/{menu}/items', [AdminMenuController::class, 'addItem'])->name('menus.add-item');
    Route::delete('menu-items/{item}', [AdminMenuController::class, 'deleteItem'])->name('menus.delete-item');
    Route::post('menus/order', [AdminMenuController::class, 'updateOrder'])->name('menus.order');

    // Newsletter
    Route::get('newsletter', [AdminNewsletterController::class, 'index'])->name('newsletter.index');
    Route::get('newsletter/export', [AdminNewsletterController::class, 'export'])->name('newsletter.export');
    Route::delete('newsletter/{subscriber}', [AdminNewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::patch('newsletter/{subscriber}/toggle-status', [AdminNewsletterController::class, 'toggleStatus'])->name('newsletter.toggle-status');
    Route::post('newsletter/bulk-delete', [AdminNewsletterController::class, 'bulkDelete'])->name('newsletter.bulk-delete');

    // Users
    Route::resource('users', AdminUserController::class);
    Route::patch('users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggle-admin');
});
