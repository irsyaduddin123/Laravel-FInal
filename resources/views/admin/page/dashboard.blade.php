@extends('layouts.admin')
@section('content')
    <h1 class="text-center" >Dashboard</h1>

    @if (session('status'))
        <h2 class="alert alert-success">{{ session('status') }}</h2>
    @endif
        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Content Row -->
                <div class="row">

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Product Data</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$products}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                             Orders Total</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{ number_format($totalPrice, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Order Confirmed
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $OrderPaid }}</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-info" role="progressbar"
                                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Order Pending</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $OrderUnpaid }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Row -->

                <div class="row">
                    <!-- Area Chart -->
                    <div class=" col-xl-8 col-lg-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Total Price Mounth</h6>
                               
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="mounthChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Total Product</h6>
                            </div>
                            <!-- Card Body -->

                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">

                                    @php
                                        $backgroundColor = ['#4e73df', '#1cc88a', '#36b9cc','#57A6A1','#FFFF80', '#FF5580', '#E1AFD1','#FFD0D0'];
                                    @endphp
                                    @foreach ($categoryNames as $key=> $item)
                                            <span class="mr-2">
                                                <i class="fas fa-circle" style="color:{{ $backgroundColor[$key] }}"></i>{{ $item }}
                                            </span>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="productSoldChart"></canvas> <!-- Tambahkan elemen canvas -->
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->




@endsection

@section('scripts')
            <script>
                // produt sold mounth
                function number_format(number, decimals, dec_point, thousands_sep) {
                // *     example: number_format(1234.56, 2, ',', ' ');
                // *     return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
                }
                // Data pesanan bulanan
        var ordersByMonth = @json($ordersByMonth);

        // Nama bulan dalam bahasa Indonesia
        var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Mengambil nama bulan dan total harga
        var monthLabels = [];
        var totalPriceData = [];
        ordersByMonth.forEach(function(order) {
            monthLabels.push(monthNames[order.month - 1]);
            totalPriceData.push(order.total_price);
        });

        // Membuat chart pesanan bulanan
        var ctxMonthlyOrders = document.getElementById("mounthChart");
        var mounthChart = new Chart(ctxMonthlyOrders, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Total Price',
                    data: totalPriceData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


                // Bar Chart Product Sold
               var soldProducts = @json($soldProducts);

                // Mengambil nama produk dan jumlah yang terjual
                var productNames = [];
                var productSoldCounts = [];

                soldProducts.forEach(function(product) {
                    productNames.push(product.product.name);
                    productSoldCounts.push(product.total_sold);
                });

                // Membuat chart
                var ctx = document.getElementById("productSoldChart");
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productNames,
                        datasets: [{
                            label: 'Units Sold',
                            data: productSoldCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });


                // Pie Chart cATEGORY->PRODUCTS
                var categoryNames = @json($categoryNames);
                var categoryProductCounts = @json($categoryProductCounts);
                // console.log(categoryNames);
                // console.log(categoryProductCounts);
                var ctx = document.getElementById("myPieChart");
                var myPieChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categoryNames,
                    datasets: [{
                    data: categoryProductCounts,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#57A6A1','#FFFF80', '#FF5580', '#E1AFD1','#FFD0D0'],
                    hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf','#006769','#FDE49E', '#FF0080', '#7469B6','#CA8787'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    },
                    legend: {
                    display: false
                    },
                    cutoutPercentage: 80,
                },
                });

            </script>
                <!-- Pie Chart -->


@endsection
