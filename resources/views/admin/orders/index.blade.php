@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách đơn hàng</h1>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Phương thức thanh toán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ number_format($order->total, 2) }} VND</td>
                <td>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý
                            </option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy
                            </option>
                        </select>
                    </form>
                </td>
                <td>
                    @if($order->payment)
                    {{ $order->payment->payment_method }}
                    <!-- Hiển thị phương thức thanh toán -->
                    @else
                    Chưa có thông tin thanh toán
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">Xem</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection