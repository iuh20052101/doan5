<?php
include "./view/home/sideheader.php";

?>
<div class="content-body">
<!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Theo Dõi Doanh Thu <span>/ Doanh Thu Theo Rạp</span></h3>
            </div>
        </div>
    </div>

    <!-- Bộ lọc rạp -->
    <div class="row mb-20">
        <div class="col-12">
            <form action="" method="GET" class="row">
                <input type="hidden" name="act" value="DTrap">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Chọn Rạp</label>
                        <select name="rap_id" class="form-control">
                            <option value="">Tất cả rạp</option>
                            <?php foreach($loadrap as $rap): ?>
                                <option value="<?=$rap['id']?>" <?=isset($_GET['rap_id']) && $_GET['rap_id']==$rap['id'] ? 'selected' : ''?>>
                                    <?=$rap['tenrap']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="button button-primary" style="margin-top: 30px;">Lọc</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng thống kê -->
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Thống kê doanh thu theo rạp</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered data-table data-table-default">
                        <thead>
                            <tr>
                                <th>ID Rạp</th>
                                <th>Tên Rạp</th>
                                <th>Địa Chỉ</th>
                                <th>Số Lượng Vé Đã Bán</th>
                                <th>Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dtt as $item): ?>
                            <tr>
                                <td><?=$item['rap_id']?></td>
                                <td><?=$item['ten_rap']?></td>
                                <td><?=$item['diachi']?></td>
                                <td><?=number_format($item['so_luong_ve_dat'])?></td>
                                <td><?=number_format($item['sum_thanhtien'])?> VNĐ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
    <tr>
        <th colspan="3">Tổng cộng</th>
        <th><?= isset($dtt) ? number_format(array_sum(array_column($dtt, 'so_luong_ve_dat'))) : 0 ?></th>
        <th><?= isset($dtt) ? number_format(array_sum(array_column($dtt, 'sum_thanhtien'))) : 0 ?> VNĐ</th>
    </tr>
</tfoot>
                    </table>
 

                    <!-- Phân trang -->
                    <ul class="pagination">
                        <?php 
                        $tong = count($dtt1);
                        $trang = ceil($tong/5);
                        for($i=1; $i<=$trang; $i++):
                        ?>
                        <li class="page-item <?=isset($_GET['trang']) && $_GET['trang']==$i ? 'active' : ''?>">
                            <a class="page-link" href="index.php?act=DTrap&trang=<?=$i?><?=isset($_GET['rap_id']) ? '&rap_id='.$_GET['rap_id'] : ''?>">
                                <?=$i?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Biểu đồ doanhthu theo rạp</h3>
                </div>
                <div class="box-body">
                    <div id="myChart" style="width:100%; height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Rạp', 'Doanh Thu'],
        <?php
        // Lấy dữ liệu tất cả các rạp bằng cách truyền null
        $allRapData = load_doanhthu_rap(null);
        foreach ($allRapData as $item) {
            echo "['".$item['ten_rap']."', ".$item['sum_thanhtien']."],";
        }
        ?>
    ]);

    var options = {
        title: 'BIỂU ĐỒ DOANH THU THEO RẠP',
        is3D: true,
        width: '100%',
        height: 500,
        chartArea: {width: '80%', height: '80%'},
        sliceVisibilityThreshold: 0
    };

    var chart = new google.visualization.PieChart(document.getElementById('myChart'));
    chart.draw(data, options);
    
    window.addEventListener('resize', function() {
        chart.draw(data, options);
    });
}
</script>