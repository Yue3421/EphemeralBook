<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Staff\ShippingController;
use app\Http\Controllers\Staff\StaffProductController;
use App\Http\Controllers\Staff\StaffDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== REDIRECT HOME ==========
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('customer.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// ========== AUTH ROUTES (GUEST ONLY) ==========
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ========== LOGOUT ==========
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ========== CUSTOMER ROUTES (HARUS LOGIN) ==========
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])->name('customer.dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Orders
    Route::get('/orders', [TransactionController::class, 'index'])->name('orders');
    Route::get('/orders/{transaction}', [TransactionController::class, 'show'])->name('orders.show');
    
    // Profile
    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('profile');
    
    // Wishlist
    Route::get('/wishlist', function () {
        return view('customer.wishlist');
    })->name('wishlist');
    
    // Contact
    Route::get('/contact', function () {
        return view('contact');
    })->name('contact');
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::put('/products/{product}/stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
    Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    
    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');
    
    // Backup
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/{backup}', [BackupController::class, 'destroy'])->name('backups.destroy');
    
    // Payments
    Route::get('/payments/pending', [PaymentController::class, 'pendingPayments'])->name('payments.pending');
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
});

// ========== STAFF ROUTES ==========
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    
    // Dashboard Staff (ubah ke controller baru)
    Route::get('/dashboard', [App\Http\Controllers\Staff\StaffDashboardController::class, 'index'])
        ->name('dashboard');

    // === STAFF PRODUCTS ===
    Route::get('/products', [App\Http\Controllers\Staff\StaffProductController::class, 'index'])
            ->name('products.index');
    Route::get('/products/create', [App\Http\Controllers\Staff\StaffProductController::class, 'create'])
        ->name('products.create');
    Route::post('/products', [App\Http\Controllers\Staff\StaffProductController::class, 'store'])
        ->name('products.store');
    Route::delete('/products/{product}', [App\Http\Controllers\Staff\StaffProductController::class, 'destroy'])
        ->name('products.destroy');
    
    // API untuk auto-update card (baru)
    Route::get('/dashboard/counts', [App\Http\Controllers\Staff\StaffDashboardController::class, 'getCounts'])
        ->name('dashboard.counts');

    // Shipping (tetap)
    Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
    Route::get('/shipping/{transaction}/process', [ShippingController::class, 'process'])->name('shipping.process');
    Route::post('/shipping/{transaction}/ship', [ShippingController::class, 'ship'])->name('shipping.ship');
    Route::post('/shipping/{transaction}/delivered', [ShippingController::class, 'markDelivered'])->name('shipping.delivered');
});
