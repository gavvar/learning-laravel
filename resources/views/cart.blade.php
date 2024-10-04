@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Giỏ hàng của bạn</h2>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
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
            @foreach(session('cart', []) as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['price'] }} $</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['price'] * $item['quantity'] }} $</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Thanh toán</button>
    </form>
</div>
@endsection