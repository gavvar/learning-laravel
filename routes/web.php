<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\ProductControllerAdmin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\OrderControlleradmin;
use App\Http\Controllers\ProductController;


// Trang chính
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route cho admin với middleware auth và admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Trang Dashboard cho admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index'); // Hiển thị danh sách danh mục
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create'); // Hiển thị form tạo danh mục
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store'); // Lưu danh mục mới
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('admin.categories.show'); // Hiển thị chi tiết danh mục
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit'); // Hiển thị form chỉnh sửa danh mục
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update'); // Cập nhật danh mục
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy'); // Xóa danh mục

    // Route cho quản lý sản phẩm
    Route::get('/products', [ProductControllerAdmin::class, 'index'])->name('admin.products.index'); // Hiển thị danh sách sản phẩm
    Route::get('/products/create', [ProductControllerAdmin::class, 'create'])->name('admin.products.create'); // Hiển thị form tạo sản phẩm
    Route::post('/products', [ProductControllerAdmin::class, 'store'])->name('admin.products.store'); // Lưu sản phẩm mới
    Route::get('/products/{product}', [ProductControllerAdmin::class, 'show'])->name('admin.products.show'); // Hiển thị chi tiết sản phẩm
    Route::get('/products/{product}/edit', [ProductControllerAdmin::class, 'edit'])->name('admin.products.edit'); // Hiển thị form chỉnh sửa sản phẩm
    Route::put('/products/{product}', [ProductControllerAdmin::class, 'update'])->name('admin.products.update'); // Cập nhật sản phẩm
    Route::delete('/products/{product}', [ProductControllerAdmin::class, 'destroy'])->name('admin.products.destroy'); // Xóa sản phẩm

    // Route quản lý đơn hàng
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderControlleradmin::class, 'index'])->name('admin.orders.index');
    Route::patch('/orders/{order}', [\App\Http\Controllers\Admin\OrderControlleradmin::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\Admin\OrderControlleradmin::class, 'cancel'])->name('admin.orders.cancel');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderControlleradmin::class, 'show'])->name('admin.orders.show');

    // Route quản lý báo cáo
   Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
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
Route::get('/product/{id}', [ProductControllerAdmin::class, 'show'])->name('product.show');

// Route welcome
Route::get('/welcome', function () {
    return view('welcome');
});
//route product cho khach hang
Route::get('/products', [ProductControllerAdmin::class, 'show'])->name('product.show');