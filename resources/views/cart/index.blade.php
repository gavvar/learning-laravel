@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Giỏ hàng của bạn</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(count($cart) > 0)
    @php
    $total = 0;
    $totalQuantity = 0;
    @endphp
    <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">
            <!-- Điều chỉnh phần bảng rộng hơn -->
            <div class="col-md-9">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="width: 5%"></th> <!-- Checkbox column -->
                            <th style="width: 35%">Tên sản phẩm</th>
                            <th style="width: 15%">Số lượng</th>
                            <th style="width: 15%">Giá</th>
                            <th style="width: 15%">Danh mục</th>
                            <th style="width: 15%">Tổng</th>
                            <th style="width: 10%">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $details)
                        @php
                        $itemTotal = $details['quantity'] * $details['price'];
                        $total += $itemTotal;
                        $totalQuantity += $details['quantity'];
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="{{ $id }}" class="item-checkbox">
                            </td>
                            <td>{{ $details['name'] }}</td>
                            <td>
                                <div class="input-group d-flex justify-content-center align-items-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                        class="d-inline update-quantity-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="quantity" value="{{ $details['quantity'] }}"
                                            class="form-control text-center quantity-input">
                                    </form>
                                </div>
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

            <!-- Điều chỉnh phần tổng tiền nhỏ lại -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng tiền giỏ hàng</h5>
                        <p class="card-text">Tổng sản phẩm: <span id="total-quantity">{{ $totalQuantity }}</span></p>
                        <p class="card-text">Tổng tiền hàng: <span
                                id="total-price">{{ number_format($total, 0) }}</span> $</p>
                        <p class="card-text">Tạm tính: <span id="sub-total">{{ number_format($total, 0) }}</span> $</p>
                        <h4>Thành tiền: <span id="final-total">{{ number_format($total, 0) }}</span> $</h4>
                        <button type="submit" class="btn btn-dark btn-block">Đặt hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
    <p>Giỏ hàng của bạn trống.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a> <!-- Sửa lại route này -->
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm cập nhật tổng tiền dựa trên checkbox
    function updateTotal() {
        let total = 0;
        let totalQuantity = 0;
        document.querySelectorAll('.item-checkbox:checked').forEach(function(checkbox) {
            const row = checkbox.closest('tr');
            const itemTotal = parseFloat(row.querySelector('td:nth-child(6)').innerText.replace(
                /[^0-9.-]+/g, ""));
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            total += itemTotal;
            totalQuantity += quantity;
        });

        document.getElementById('total-price').innerText = total.toLocaleString();
        document.getElementById('sub-total').innerText = total.toLocaleString();
        document.getElementById('final-total').innerText = total.toLocaleString();
        document.getElementById('total-quantity').innerText = totalQuantity;
    }

    // Gán sự kiện 'change' cho checkbox để tính lại tổng tiền khi người dùng tích chọn
    document.querySelectorAll('.item-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', updateTotal);
    });

    // Gọi updateTotal() khi trang được tải lại để tính tổng ban đầu dựa trên checkbox
    updateTotal();

    // Decrease quantity
    document.querySelectorAll('.btn-decrease').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
                input.closest('form').submit();
            }
        });
    });

    // Increase quantity
    document.querySelectorAll('.btn-increase').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value = parseInt(input.value) + 1;
            input.closest('form').submit();
        });
    });
});
</script>
@endsection