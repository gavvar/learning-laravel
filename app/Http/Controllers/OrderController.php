<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment; // Thêm dòng này
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function checkout(Request $request)
{
    $user = Auth::user(); // Lấy thông tin người dùng hiện tại
    $cart = session()->get('cart', []); // Lấy giỏ hàng từ session
    
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống.');
    }

    // Tính tổng tiền
    $total = 0;
    foreach ($cart as $item) {
        if (!isset($item['id'])) {
            return redirect()->route('cart.index')->with('error', 'Invalid cart item.');
        }
        $total += $item['price'] * $item['quantity']; // Tính tổng tiền
    }

    // Tạo đơn hàng
    $order = Order::create([
        'user_id' => $user->id,
        'total' => $total,
        'status' => 'pending', // Trạng thái đơn hàng ban đầu
    ]);

    // Tạo các mục đơn hàng
    foreach ($cart as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    // Thêm thông tin thanh toán
    Payment::create([
        'order_id' => $order->id, // Liên kết với đơn hàng
        'amount' => $total, // Tổng số tiền
        'payment_date' => now(), // Thời gian thanh toán
        'payment_method' => $request->payment_method, // Lưu phương thức thanh toán
    ]);

    // Xóa giỏ hàng khỏi session
    session()->forget('cart');

    return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
}

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}