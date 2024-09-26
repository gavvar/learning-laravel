@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @php
    $totalQuantity = 0;
    foreach($cart as $details) {
    $totalQuantity += $details['quantity'];
    }
    @endphp
    <h2 class="mb-4">Giỏ hàng của bạn <span class="text-danger">{{ $totalQuantity }} Sản Phẩm</span></h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(count($cart) > 0)
    @php
    $total = 0;
    @endphp
    <div class="row">
        <div class="col-md-8">
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
                    @foreach($cart as $id => $details)
                    @php
                    $itemTotal = $details['quantity'] * $details['price'];
                    $total += $itemTotal;
                    @endphp
                    <tr>
                        <td>{{ $details['name'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST"
                                class="d-flex align-items-center update-quantity-form">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="btn btn-light btn-sm btn-decrease">-</button>
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1"
                                    class="form-control text-center mx-2 quantity-input" style="width: 50px;">
                                <button type="button" class="btn btn-light btn-sm btn-increase">+</button>
                            </form>
                        </td>
                        <td>{{ number_format($details['price'], 0) }} $</td>
                        <td>{{ $details['category'] }}</td>
                        <td>{{ number_format($itemTotal, 0) }} $</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phần tổng tiền -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tổng tiền giỏ hàng</h5>
                    <p class="card-text">Tổng sản phẩm: {{ $totalQuantity }}</p>
                    <p class="card-text">Tổng tiền hàng: {{ number_format($total, 0) }} $</p>
                    <p class="card-text">Tạm tính: {{ number_format($total, 0) }} $</p>
                    <h4>Thành tiền: {{ number_format($total, 0) }} $</h4>
                    <a href="#" class="btn btn-dark btn-block">Đặt hàng</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <p>Giỏ hàng của bạn trống.</p>
    <a href="{{ route('welcome') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-decrease').forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.nextElementSibling;
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                input.closest('form').submit();
            }
        });
    });

    document.querySelectorAll('.btn-increase').forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            input.closest('form').submit();
        });
    });
});
</script>
@endsection