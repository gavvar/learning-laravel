@extends('layouts.app')

@section('title', 'Báo cáo')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Báo cáo Doanh thu</h1>

    <div class="mt-4">
        <h4>Tổng số đơn hàng: <span class="text-success">{{ $totalOrders }}</span></h4>
        <h4>Tổng số khách hàng: <span class="text-success">{{ $totalCustomers }}</span></h4>
    </div>

    <div class="mt-5">
        <h3 class="border-bottom pb-2">Doanh thu theo từng danh mục</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Danh mục</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoryRevenue as $revenue)
                <tr>
                    <td>{{ $revenue->category_id }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <h3 class="border-bottom pb-2">Doanh thu theo ngày</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Ngày</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByDate as $revenue)
                <tr>
                    <td>{{ $revenue->date }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <h3 class="border-bottom pb-2">Doanh thu theo tháng</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Tháng</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByMonth as $revenue)
                <tr>
                    <td>{{ $revenue->month }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        <h3 class="border-bottom pb-2">Doanh thu theo năm</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Năm</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByYear as $revenue)
                <tr>
                    <td>{{ $revenue->year }}</td>
                    <td>{{ number_format($revenue->total_revenue, 2) }} VND</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection