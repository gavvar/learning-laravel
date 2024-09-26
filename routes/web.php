<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

// Trang chính
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route cho admin với middleware auth và admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Trang Dashboard cho admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Các route quản lý danh mục và sản phẩm cho admin
    Route::resource('admin/categories', CategoryController::class);
    Route::resource('admin/products', ProductController::class);
});

// Route cho người dùng (đăng ký, đăng nhập và đăng xuất)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route để thêm sản phẩm vào giỏ hàng
Route::middleware(['auth'])->post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

// Route để hiển thị giỏ hàng
Route::middleware(['auth'])->get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route để xóa sản phẩm khỏi giỏ hàng
Route::middleware(['auth'])->delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Route để cập nhật thông tin giỏ hàng
Route::middleware(['auth'])->patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// Route để hiển thị chi tiết sản phẩm
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');