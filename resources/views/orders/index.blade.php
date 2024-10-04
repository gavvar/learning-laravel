@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Đơn hàng của tôi</h2>
    @if($orders->isEmpty())
    <p>Bạn chưa có đơn hàng nào.</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt hàng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ number_format($order->total, 0) }} $</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection