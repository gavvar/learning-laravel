<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
class DashboardController extends Controller
{
    public function index()
    {
        // Đếm tổng số người dùng
        $totalUsers = User::count();

        // Đếm tổng số sản phẩm
        $totalProducts = Product::count();

        // Đếm tổng số đơn hàng
        $totalOrders = Order::count();

        // Tính tổng doanh thu
        $totalRevenue = Payment::sum('amount'); // Nếu bạn sử dụng model Payment

        // Lấy danh sách đơn hàng gần đây (giả sử là 5 đơn hàng gần nhất)
        $recentOrders = Order::with('user', 'payment') // Lấy thông tin người dùng và phương thức thanh toán
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo
            ->take(5) // Lấy 5 đơn hàng gần đây
            ->get();

        // Truyền các biến vào view
        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'));
    }
}