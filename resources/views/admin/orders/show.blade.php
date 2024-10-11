@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mt-4">Chi tiết đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 2) }} VND</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment->payment_method ?? 'Chưa có thông tin thanh toán' }}
    </p>
    <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p> <!-- Thêm ngày đặt hàng -->

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ number_format($item->price, 2) }} VND</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} VND</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
</div>
@endsection