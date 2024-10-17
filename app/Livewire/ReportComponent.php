<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportComponent extends Component
{
    public $categoryRevenue;
    public $totalOrders;
    public $totalCustomers;
    public $revenueByDate;
    public $revenueByMonth;
    public $revenueByYear;
    public $revenueByPaymentMethod;

    public function mount()
    {
        // Lấy dữ liệu từ database
        $this->categoryRevenue = DB::table('order_items')
            ->select('products.category_id', DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'paid')
            ->groupBy('products.category_id')
            ->get();

        $this->totalOrders = Order::count();

        $this->totalCustomers = DB::table('users')->where('role', 'customer')->count();

        $this->revenueByDate = Order::select(DB::raw('DATE(created_at) as date, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('date')
            ->get();

        $this->revenueByMonth = Order::select(DB::raw('MONTH(created_at) as month, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('month')
            ->get();

        $this->revenueByYear = Order::select(DB::raw('YEAR(created_at) as year, SUM(total) as total_revenue'))
            ->where('status', 'paid')
            ->groupBy('year')
            ->get();

        $this->revenueByPaymentMethod = DB::table('payments')
            ->select('payment_method', DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('payment_method')
            ->get();
    }

    public function render()
    {
        return view('livewire.report-component');
    }
}
