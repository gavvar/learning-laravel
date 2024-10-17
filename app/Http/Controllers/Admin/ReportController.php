<?php   
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Category;

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
            ->get()
            ->map(function ($item) {
                $item->category = Category::find($item->category_id);
                return $item;
            });

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = DB::table('users')->where('role', 'user')->count();
        // tổng số sản phẩm
        $totalProducts = DB::table('products')->count();
        // tổng số danh mục
        $totalCategories = DB::table('categories')->count();
        // tổng số đơn hàng đã hoàn thành
        $totalOrdersPaid = DB::table('orders')->where('status', 'paid')->count();
        // tổng số đơn hàng đã hủy
        $totalOrdersCancelled = DB::table('orders')->where('status', 'cancelled')->count();
        // tổng số đơn hàng đang chờ xử lý
        $totalOrdersPending = DB::table('orders')->where('status', 'pending')->count();
        
        // Doanh thu theo ngày
        $revenueByDate = Order::select(DB::raw('DATE(created_at) as date, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Doanh thu theo tháng
        $revenueByMonth = Order::select(DB::raw('MONTH(created_at) as month, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Doanh thu theo năm
        $revenueByYear = Order::select(DB::raw('YEAR(created_at) as year, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->get();

        // Doanh thu theo phương thức thanh toán (từ bảng payments)
        $revenueByPaymentMethod = DB::table('payments')
            ->select('payment_method', DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('payment_method')
            ->get();

        // Truyền dữ liệu từ PHP sang view
        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalOrdersPaid',
            'totalOrdersCancelled',
            'totalOrdersPending',
            'totalCustomers',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear',
            'revenueByPaymentMethod'
        ));
    }
}