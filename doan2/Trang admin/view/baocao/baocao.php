<?php
include "./view/home/sideheader.php";
?>

<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Báo Cáo Doanh Thu</h3>
                </div>
                <div class="box-body">
                    <!-- Thống kê tổng quan -->
                    <div class="row">
                        <!-- Doanh thu hôm nay -->
                        <div class="col-md-4 mb-20">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <?php
                                    $today = date('Y-m-d');
                                    $dt_ngay = thongke_phim_theo_ngay($today, $rap_id);
                                    $total_ngay = 0;
                                    foreach($dt_ngay as $item) {
                                        $total_ngay += $item['sum_thanhtien'];
                                    }
                                    ?>
                                    <h5>Doanh Thu Hôm Nay</h5>
                                    <h3><?= number_format($total_ngay) ?> VNĐ</h3>
                                    <p>Ngày: <?= date('d/m/Y', strtotime($today)) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Doanh thu tuần này -->
                        <div class="col-md-4 mb-20">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <?php
                                    $current_week = date('YW');
                                    $dt_tuan = thongke_phim_theo_tuan($current_week, $rap_id);
                                    $total_tuan = 0;
                                    foreach($dt_tuan as $item) {
                                        $total_tuan += $item['sum_thanhtien'];
                                    }
                                    
                                    // Lấy ngày đầu và cuối tuần
                                    $year = substr($current_week, 0, 4);
                                    $week = substr($current_week, 4);
                                    $dto = new DateTime();
                                    $dto->setISODate($year, $week);
                                    $start = $dto->format('d/m/Y');
                                    $dto->modify('+6 days');
                                    $end = $dto->format('d/m/Y');
                                    ?>
                                    <h5>Doanh Thu Tuần Này</h5>
                                    <h3><?= number_format($total_tuan) ?> VNĐ</h3>
                                    <p>Từ <?=$start?> đến <?=$end?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Doanh thu tháng này -->
                        <div class="col-md-4 mb-20">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <?php
                                    $current_month = date('m');
                                    $current_year = date('Y');
                                    $dt_thang = thongke_phim_theo_thang($current_month, $current_year, $rap_id);
                                    $total_thang = 0;
                                    foreach($dt_thang as $item) {
                                        $total_thang += $item['sum_thanhtien'];
                                    }
                                    ?>
                                    <h5>Doanh Thu Tháng Này</h5>
                                    <h3><?= number_format($total_thang) ?> VNĐ</h3>
                                    <p>Tháng <?=$current_month?>/<?=$current_year?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách báo cáo chi tiết -->
                    <div class="row">
                        <!-- Báo cáo theo ngày -->
                        <div class="col-md-4 mb-20">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Báo Cáo Theo Ngày</h4>
                                    <p>Xem chi tiết doanh thu và thống kê theo từng ngày</p>
                                    <div class="mt-4">
                                        <a href="index.php?act=baocao_ngay<?=isset($_GET['rap_id']) ? '&rap_id='.$_GET['rap_id'] : ''?>" 
                                           class="button button-primary">
                                            <i class="fa fa-calendar-day"></i> Xem báo cáo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Báo cáo theo tuần -->
                        <div class="col-md-4 mb-20">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Báo Cáo Theo Tuần</h4>
                                    <p>Xem chi tiết doanh thu và thống kê theo từng tuần</p>
                                    <div class="mt-4">
                                        <a href="index.php?act=baocao_tuan<?=isset($_GET['rap_id']) ? '&rap_id='.$_GET['rap_id'] : ''?>" 
                                           class="button button-primary">
                                            <i class="fa fa-calendar-week"></i> Xem báo cáo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Báo cáo theo tháng -->
                        <div class="col-md-4 mb-20">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Báo Cáo Theo Tháng</h4>
                                    <p>Xem chi tiết doanh thu và thống kê theo từng tháng</p>
                                    <div class="mt-4">
                                        <a href="index.php?act=baocao_thang<?=isset($_GET['rap_id']) ? '&rap_id='.$_GET['rap_id'] : ''?>" 
                                           class="button button-primary">
                                            <i class="fa fa-calendar-alt"></i> Xem báo cáo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ thống kê -->
                    <div class="row">
                        <div class="col-12 mb-30">
                            <div class="box">
                                <div class="box-head">
                                    <h4>Biểu Đồ Doanh Thu 12 Tháng Gần Nhất</h4>
                                </div>
                                <div class="box-body">
                                    <div id="chartDoanhThu" style="width:100%; height:400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Lấy dữ liệu 12 tháng gần nhất
    const data = google.visualization.arrayToDataTable([
        ['Tháng', 'Doanh Thu'],
        <?php
        for($i = 11; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $dt = thongke_phim_theo_thang($month, $year, $rap_id);
            $total = 0;
            foreach($dt as $item) {
                $total += $item['sum_thanhtien'];
            }
            echo "['Tháng $month/$year', $total],";
        }
        ?>
    ]);

    const options = {
        title: 'Biểu đồ doanh thu 12 tháng gần nhất',
        curveType: 'function',
        legend: { position: 'bottom' },
        colors: ['#4285F4'],
        backgroundColor: { fill:'transparent' }
    };

    const chart = new google.visualization.LineChart(document.getElementById('chartDoanhThu'));
    chart.draw(data, options);

    // Responsive
    window.addEventListener('resize', function() {
        chart.draw(data, options);
    });
}
</script>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.bg-primary {
    background-color: #4285F4 !important;
}
.bg-success {
    background-color: #34A853 !important;
}
.bg-info {
    background-color: #4285F4 !important;
}
.text-white {
    color: white !important;
}
.card-body {
    padding: 20px;
}
.card-body h3 {
    margin: 10px 0;
    font-size: 24px;
}
.card-body p {
    margin: 0;
    opacity: 0.8;
}
.button i {
    margin-right: 5px;
}
</style>