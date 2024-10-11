@extends('layouts.app')
<!-- Sử dụng layout admin -->

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Danh sách sản phẩm 2</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Thêm sản phẩm</a>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ number_format($product->price, 2) }} VND</td> <!-- Định dạng tiền tệ -->
                <td>{{ $product->category->name }}</td>
                <td>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info">Xem</a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection