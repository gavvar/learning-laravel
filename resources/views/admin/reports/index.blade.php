<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng điều khiển Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .section-title {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: left;
            margin-bottom: 20px;
        }

        .stat-card {
            min-height: 120px;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .chart-container {
            max-width: 400px;
            margin: 0 auto 30px auto;
        }

        .grid {
            gap: 20px;
        }

        .chart-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-blue-600 text-white py-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-6">
            <h1 class="text-2xl font-bold">Bảng Điều Khiển Admin</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 px-4 py-2 rounded shadow hover:bg-red-700 transition">Đăng xuất</button>
            </form>
        </div>
    </header>

    <!-- Content -->
    <div class="container mx-auto p-6 mt-6">
        <!-- Overview -->
        <h2 class="section-title text-xl font-semibold uppercase">Thống kê</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-box text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalOrders }}</h2>
                    <p class="text-lg">Đơn hàng</p>
                    <a href="{{ route('admin.orders.index') }}" class="block text-white mt-2 py-1 hover:underline">Xem đơn hàng</a>
                </div>
            </div>
            <div class="bg-green-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-users text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalCustomers }}</h2>
                    <p class="text-lg">Khách hàng</p>
                </div>
            </div>
            <div class="bg-orange-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-dollar-sign text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalProducts }}</h2>
                    <p class="text-lg">Tổng số sản phẩm</p>
                </div>
            </div>
            <div class="bg-purple-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-th-list text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalCategories }}</h2>
                    <p class="text-lg">Danh mục</p>
                </div>
            </div>
            <div class="bg-yellow-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-check-circle text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalOrdersPaid }}</h2>
                    <p class="text-lg">Đơn hàng đã hoàn thành</p>
                </div>
            </div>
            <div class="bg-red-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-times-circle text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalOrdersCancelled }}</h2>
                    <p class="text-lg">Đơn hàng đã hủy</p>
                </div>
            </div>
            <div class="bg-gray-600 text-white p-4 rounded-lg shadow flex items-center stat-card">
                <i class="fas fa-clock text-4xl mr-4"></i>
                <div>
                    <h2 class="text-3xl">{{ $totalOrdersPending }}</h2>
                    <p class="text-lg">Đơn hàng đang chờ xử lý</p>
                </div>
            </div>
        </div>

        <!-- Biểu đồ thống kê -->
        <h2 class="section-title text-xl font-semibold uppercase">Doanh thu (USD)</h2>
        <div class="chart-row">
            <div class="chart-container">
                <canvas id="revenueByDateChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="revenueByMonthChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="revenueByYearChart"></canvas>
            </div>
        </div>

        <!-- Revenue by Date Chart -->
        <script>
            const dateLabels = JSON.parse('<?php echo json_encode($revenueByDate->pluck('date')); ?>');
            const dateData = JSON.parse('<?php echo json_encode($revenueByDate->pluck('total_revenue')); ?>');
            var ctx2 = document.getElementById('revenueByDateChart').getContext('2d');
            var revenueByDateChart = new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'Doanh thu theo ngày',
                        data: dateData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- Doanh thu theo tháng -->
        <script>
            const monthLabels = JSON.parse('<?php echo json_encode($revenueByMonth->pluck('month')); ?>');
            const monthData = JSON.parse('<?php echo json_encode($revenueByMonth->pluck('total_revenue')); ?>');
            var ctx3 = document.getElementById('revenueByMonthChart').getContext('2d');
            var revenueByMonthChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Doanh thu theo tháng',
                        data: monthData,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- Doanh thu theo năm -->
        <script>
            const yearLabels = JSON.parse('<?php echo json_encode($revenueByYear->pluck('year')); ?>');
            const yearData = JSON.parse('<?php echo json_encode($revenueByYear->pluck('total_revenue')); ?>');
            var ctx4 = document.getElementById('revenueByYearChart').getContext('2d');
            var revenueByYearChart = new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        label: 'Doanh thu theo năm',
                        data: yearData,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- Doanh thu theo danh mục -->
        <h2 class="section-title text-xl font-semibold uppercase">Doanh thu theo danh mục (USD)</h2>
        <div class="chart-container">
            <canvas id="categoryRevenueChart"></canvas>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoryLabels = JSON.parse('<?php echo json_encode($categoryRevenue->pluck('category.name')); ?>');
                const categoryData = JSON.parse('<?php echo json_encode($categoryRevenue->pluck('total_revenue')); ?>');
                var ctx1 = document.getElementById('categoryRevenueChart').getContext('2d');
                var categoryRevenueChart = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            label: 'Doanh thu',
                            data: categoryData,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>

        <!-- Doanh thu theo phương thức thanh toán -->
        <h2 class="section-title text-xl font-semibold uppercase">Doanh thu theo phương thức thanh toán (USD)</h2>
        <div class="chart-container">
            <canvas id="revenueByPaymentMethodChart"></canvas>
        </div>

        <script>
            const paymentMethodLabels = JSON.parse('<?php echo json_encode($revenueByPaymentMethod->pluck('payment_method')); ?>');
            const paymentMethodData = JSON.parse('<?php echo json_encode($revenueByPaymentMethod->pluck('total_revenue')); ?>');
            var ctx5 = document.getElementById('revenueByPaymentMethodChart').getContext('2d');
            var revenueByPaymentMethodChart = new Chart(ctx5, {
                type: 'pie',
                data: {
                    labels: paymentMethodLabels,
                    datasets: [{
                        label: 'Doanh thu theo phương thức thanh toán',
                        data: paymentMethodData,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 206, 86, 0.5)',
                            'rgba(75, 192, 192, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + new Intl.NumberFormat().format(context.raw) + ' USD';
                                }
                            }
                        }
                    }
                }
            });
        </script>

    </div>

</body>

</html>
