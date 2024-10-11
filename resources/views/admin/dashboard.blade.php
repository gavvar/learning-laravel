@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Statistics</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Users:</strong> {{ $totalUsers }}</p>
                    <p><strong>Total Products:</strong> {{ $totalProducts }}</p>
                    <p><strong>Total Orders:</strong> {{ $totalOrders }}</p>
                    <p><strong>Total Revenue:</strong> {{ number_format($totalRevenue, 2) }} VND</p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ number_format($order->total, 2) }} VND</td>
                                <td>{{ $order->payment->payment_method ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Form đăng xuất -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection