<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê tổng doanh thu theo từng danh mục
        $categoryRevenue = DB::table('order_items')
            ->select('products.category_id', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('products.category_id')
            ->get();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = DB::table('users')->where('role', 'customer')->count();

        // Doanh thu theo ngày, tháng, năm
        $revenueByDate = Order::select(DB::raw('DATE(created_at) as date, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('date')
            ->get();

        $revenueByMonth = Order::select(DB::raw('MONTH(created_at) as month, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('month')
            ->get();

        $revenueByYear = Order::select(DB::raw('YEAR(created_at) as year, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('year')
            ->get();

        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalOrders',
            'totalCustomers',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear'
        ));
    }
}