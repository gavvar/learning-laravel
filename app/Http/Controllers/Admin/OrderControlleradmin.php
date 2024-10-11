<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment; // Thêm dòng này
use Illuminate\Http\Request;

class OrderControlleradmin extends Controller
{
    public function index()
    {
        // Lấy tất cả đơn hàng để hiển thị cho admin
        $orders = Order::with('payment')->get(); // Lấy cùng thông tin thanh toán nếu cần
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Cập nhật trạng thái đơn hàng
        $order = Order::findOrFail($id);
        $order->status = $request->status; // status có thể là 'paid' hoặc 'cancelled'
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

   public function show($id)
{
    $order = Order::with(['items.product', 'payment'])->findOrFail($id); // Lấy cả thông tin thanh toán
    return view('admin.orders.show', compact('order'));
}

}