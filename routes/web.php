<?php

use App\Http\Controllers\Admin\BookController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Middleware;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CustomerController;


Route::get('/', function () {
    return view('auth.customer-login');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');


// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// 1. Add New Books
Route::get('/admin/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
Route::post('/admin/books/store', [AdminController::class, 'storeBook'])->name('admin.books.store');

// 2. Modify Existing Books
Route::get('/admin/books/search', [AdminController::class, 'searchBookForEdit'])->name('admin.books.search');
Route::get('/admin/books/edit/{isbn}', [AdminController::class, 'editBook'])->name('admin.books.edit');
Route::put('/admin/books/update/{isbn}', [AdminController::class, 'updateBook'])->name('admin.books.update');

// 4. Confirm Orders
Route::get('/admin/orders', [AdminController::class, 'listOrders'])->name('admin.orders.list');
Route::post('/admin/orders/confirm/{id}', [AdminController::class, 'confirmOrder'])->name('admin.orders.confirm');

// 5. Search for Books
Route::get('/admin/books/search-general', [AdminController::class, 'searchBooks'])->name('admin.books.search.general');

// 6. System Reports
Route::get('/admin/reports', [AdminController::class, 'reportsMenu'])->name('admin.reports.menu');
Route::get('/admin/reports/previous-month', [AdminController::class, 'previousMonthSales'])->name('admin.reports.previous.month');
Route::get('/admin/reports/specific-day', [AdminController::class, 'specificDaySalesForm'])->name('admin.reports.specific.day.form');
Route::post('/admin/reports/specific-day', [AdminController::class, 'specificDaySales'])->name('admin.reports.specific.day');
Route::get('/admin/reports/top-customers', [AdminController::class, 'topCustomers'])->name('admin.reports.top.customers');
Route::get('/admin/reports/top-books', [AdminController::class, 'topBooks'])->name('admin.reports.top.books');
Route::get('/admin/reports/book-orders', [AdminController::class, 'bookOrdersForm'])->name('admin.reports.book.orders.form');
Route::post('/admin/reports/book-orders', [AdminController::class, 'bookOrdersCount'])->name('admin.reports.book.orders');

Route::get('/db-test', function () {
    try {
        return User::count() . ' users';
    } catch (\Exception $e) {
        return response('DB ERROR: ' . $e->getMessage(), 500);
    }
});

// Cart routes
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/add/{isbn}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{isbn}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Customer profile / orders / logout
Route::get('/profile/edit', [CartController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile', [CartController::class, 'updateProfile'])->name('profile.update');
Route::get('/orders', [CartController::class, 'pastOrders'])->name('orders.index');
// Route::post('/logout', [CartController::class, 'logout'])->name('customer.logout');

// Admin auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin area - book CRUD (protected by AdminAuth middleware)
// Route::prefix('admin')->middleware([\App\Http\Middleware\AdminAuth::class])->name('admin.')->group(function () {
//     Route::resource('books', \App\Http\Controllers\Admin\BookController::class);
// });

Route::get('/admin/books/index', [BookController::class, 'index'])->name('admin.books.index');

Route::post('/customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

// Development convenience route to impersonate seeded admin (local only)
Route::get('/admin/impersonate', function () {
    if (!app()->environment('local')) {
        abort(403);
    }
    session(['admin_id' => 1, 'admin_username' => 'admin_yehia']);
    return redirect()->route('admin.books.index');
});

// Theme toggle (persist in session)
Route::get('/theme/toggle', function () {
    $theme = session('theme', 'dark') === 'light' ? 'dark' : 'light';
    session(['theme' => $theme]);
    return back();
})->name('theme.toggle');

// Local-only helper to set a user's name in session (for integration with external auth)
Route::get('/auth/set-name', function () {
    if (!app()->environment('local')) {
        abort(403);
    }
    $name = request('name');
    if (!$name) {
        return response('Provide ?name=...', 400);
    }
    session(['user_name' => $name]);
    return redirect('/');
});


// Yasser

// Login
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
;

Route::get('/customer/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
Route::post('/customer/login', [CustomerAuthController::class, 'login'])->name('customer.login.submit');
;

// Register
Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

Route::get('/customer/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/customer/register', [CustomerAuthController::class, 'register'])->name('customer.register.submit');

// Customer Dashboard
Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');


Route::get('/customer/profile', [CustomerAuthController::class, 'showProfile'])->name('customer.profile');
Route::post('/customer/profile', [CustomerAuthController::class, 'updateProfile'])->name('customer.profile.submit');