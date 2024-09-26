@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6 text-center mb-4">
            <div class="product-image-container position-relative">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                    class="img-fluid rounded shadow-lg" width="400">
                @else
                <img src="https://via.placeholder.com/400" alt="{{ $product->name }}"
                    class="img-fluid rounded shadow-lg" width="400">
                @endif
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1 class="font-weight-bold mb-3">{{ $product->name }}</h1>
            <h2 class="text-danger mb-3">{{ number_format($product->price, 0) }} $</h2>

            <!-- Mô tả sản phẩm -->
            <p class="text-muted mb-4">{{ $product->description }}</p>
            <p class="mb-2"><strong>Số lượng:</strong> {{ $product->quantity }}</p>
            <p class="mb-4"><strong>Danh mục:</strong> {{ $product->category->name }}</p>

            @auth
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="my-4">
                @csrf
                <div class="form-group d-flex align-items-center">
                    <label for="quantity" class="mr-3"><strong>Số lượng:</strong></label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                        class="form-control d-inline-block" style="width: 80px;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Thêm vào giỏ hàng</button>
            </form>
            @else
            <p class="text-danger">Vui lòng <a href="{{ route('login') }}" class="text-primary">đăng nhập</a> để thêm
                sản phẩm vào giỏ hàng.</p>
            @endauth

            <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3 btn-block">Quay lại danh sách</a>
        </div>
    </div>
</div>
@endsection