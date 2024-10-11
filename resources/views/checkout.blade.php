@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container">
    <h1 class="my-4">Thanh toán</h1>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="payment_method" class="form-label">Phương thức thanh toán</label>
            <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="online">Thanh toán trực tuyến</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận đơn hàng</button>
    </form>
</div>
@endsection