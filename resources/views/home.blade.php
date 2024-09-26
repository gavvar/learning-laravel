@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Featured Products</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(isset($products) && count($products) > 0)
    <div class="row">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-image"
                    alt="{{ $product->name }}">
                @else
                <img src="https://via.placeholder.com/150" class="card-img-top product-image"
                    alt="{{ $product->name }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">${{ $product->price }}</p>
                    @auth
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary">Add to Cart</button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No products available.</p>
    <a href="{{ route('welcome') }}" class="btn btn-primary">Continue Shopping</a>
    @endif
</div>
@endsection

<style>
.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
</style>