@extends('layouts.user')

@section('content')
<div class="container mt-5">
    <h2>Chi tiết đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
    <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0) }} $</p>

    <!-- Thêm thông tin phương thức thanh toán -->
    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment->payment_method ?? 'Chưa có thông tin' }}</p>
    <!-- Kiểm tra nếu payment không null -->

    <!-- Thêm thông tin ngày thanh toán -->
    <p><strong>Ngày thanh toán:</strong> {{ $order->payment->payment_date ?? 'Chưa có thông tin' }}</p>
    <!-- Kiểm tra nếu payment không null -->

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
                <td>{{ number_format($item->price, 0) }} $</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 0) }} $</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('home') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
@endsection