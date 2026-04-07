<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Staff\ShippingController;
use app\Http\Controllers\Staff\StaffProductController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Staff\OrderController;

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
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [TransactionController::class, 'store'])->name('checkout.store');
    Route::get('/payments/{transaction}', [TransactionController::class, 'payment'])->name('payments.show');

    // Addresses
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');
    
    // Orders
    Route::get('/orders', [TransactionController::class, 'index'])->name('orders');
    Route::get('/orders/{transaction}', [TransactionController::class, 'show'])->name('orders.show');
    Route::post('/orders/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('orders.cancel');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
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
    Route::get('/backups/restore', [BackupController::class, 'showRestore'])->name('backups.restoreForm');
    Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/{backup}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/{backup}', [BackupController::class, 'destroy'])->name('backups.destroy');
    
    // Payments
    Route::get('/payments/pending', [PaymentController::class, 'pendingPayments'])->name('payments.pending');
    Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');

    // Staff List
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

    // User List
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
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

    // === EDIT & UPDATE ===
    Route::get('/products/{product}/edit', [App\Http\Controllers\Staff\StaffProductController::class, 'edit'])
        ->name('products.edit');
    Route::put('/products/{product}', [App\Http\Controllers\Staff\StaffProductController::class, 'update'])
        ->name('products.update');
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

    // Order List (Staff UI)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{transaction}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{transaction}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::put('/orders/{transaction}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.paymentStatus');
    Route::post('/orders/{transaction}/confirm', [OrderController::class, 'confirmPayment'])->name('orders.confirm');
    Route::post('/orders/{transaction}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});
