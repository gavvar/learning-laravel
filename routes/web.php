<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

// Trang chính
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route cho admin với middleware auth và admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Trang Dashboard cho admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Các route quản lý danh mục và sản phẩm cho admin
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});

// Route cho người dùng (đăng ký, đăng nhập và đăng xuất)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route cho người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
    // Route để thêm sản phẩm vào giỏ hàng
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // Route để hiển thị giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Route để xóa sản phẩm khỏi giỏ hàng
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Route để cập nhật thông tin giỏ hàng
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // Route cho chức năng thanh toán
     Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Route cho trang chi tiết sản phẩm
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
//route welcome
Route::get('/welcome', function () {
    return view('welcome');
});