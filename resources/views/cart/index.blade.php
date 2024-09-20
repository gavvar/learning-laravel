@extends('layouts.app')

@section('content')
<h1>Giỏ hàng của bạn</h1>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(count($cart) > 0)
<table class="table">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Danh mục</th>
            <th>Tổng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($cart as $id => $details)
        @php
        $itemTotal = $details['quantity'] * $details['price'];
        $total += $itemTotal;
        @endphp
        <tr>
            <td>{{ $details['name'] }}</td>
            <td>
                <form action="{{ route('cart.update', $id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control"
                        style="width: 60px; display: inline;">
                    <button type="submit" class="btn btn-secondary btn-sm">Cập nhật</button>
                </form>
            </td>
            <td>{{ number_format($details['price'], 2) }} đ</td>
            <td>{{ $details['category'] }}</td>
            <td>{{ number_format($itemTotal, 2) }} đ</td>
            <td>
                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-right">
    <h4><strong>Tổng tiền: {{ number_format($total, 2) }} đ</strong></h4>
</div>
@else
<p>Giỏ hàng của bạn trống.</p>
<a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
@endif
@endsection