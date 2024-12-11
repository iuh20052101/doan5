<?php
include "./view/home/sideheader.php";
$tong = count($dtt1);
$trang = ceil($tong/4);
?>
<div class="content-body">
<!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Theo Dõi Doanh Thu <span>/ Doanh Thu Theo Tháng</span></h3>
            </div>
        </div>
    </div>

    <!-- Bộ lọc rạp -->
    <div class="row mb-20">
        <div class="col-12">
            <form action="" method="GET" class="row">
                <input type="hidden" name="act" value="DTthang">
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
                    <h3 class="title">Thống kê doanh thu theo tháng</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered data-table data-table-default">
                        <thead>
                            <tr>
                                <th>ID Rạp</th>
                                <th>Tên Rạp</th>
                                <th>Địa Chỉ</th>
                                <th>Tháng/Năm</th>
                                <th>Số Lượng Vé</th>
                                <th>Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($dtt as $item): ?>
                            <tr>
                                <td><?=$item['rap_id']?></td>
                                <td><?=$item['ten_rap']?></td>
                                <td><?=$item['diachi']?></td>
                                <td><?=$item['thang']?>/<?=$item['nam']?></td>
                                <td><?=number_format($item['so_luong_ve_dat'])?></td>
                                <td><?=number_format($item['sum_thanhtien'])?> VNĐ</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
    <tr>
        <th colspan="4">Tổng cộng</th>
        <th><?= isset($dtt) ? number_format(array_sum(array_column($dtt, 'so_luong_ve_dat'))) : 0 ?></th>
        <th><?= isset($dtt) ? number_format(array_sum(array_column($dtt, 'sum_thanhtien'))) : 0 ?> VNĐ</th>
    </tr>
</tfoot>
                    </table>
                    <div class="row">
    <div class="col-12 mb-30">
        <div class="box">
            <div class="box-head">
                <h3 class="title">Biểu đồ doanh thu theo tháng</h3>
            </div>
            <div class="box-body">
                <div id="myChart" style="width:100%; height:500px;"></div>
            </div>
        </div>
    </div>
</div>

                    <!-- Phân trang -->
                    <ul class="pagination">
                        <?php 
                        $tong = count($dtt1);
                        $trang = ceil($tong/5);
                        for($i=1; $i<=$trang; $i++):
                        ?>
                        <li class="page-item <?=isset($_GET['trang']) && $_GET['trang']==$i ? 'active' : ''?>">
                            <a class="page-link" href="index.php?act=DTthang&trang=<?=$i?><?=isset($_GET['rap_id']) ? '&rap_id='.$_GET['rap_id'] : ''?>">
                                <?=$i?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    const data = google.visualization.arrayToDataTable([
        ['Tháng', 'Doanh Thu'],
        <?php
        foreach ($dtt as $item) {
            echo "['".$item['thang']."/".$item['nam']."', "
                .(int)$item['sum_thanhtien']."],";
        }
        ?>
    ]);

    const options = {
        chart: {
            title: 'BIỂU ĐỒ DOANH THU THEO THÁNG',
        },
        bars: 'vertical',
        vAxis: {
            format: 'decimal',
            title: 'Doanh Thu (VNĐ)'
        },
        height: 400,
        colors: ['#4285F4'],
        backgroundColor: { fill:'transparent' }
    };

    const chart = new google.charts.Bar(document.getElementById('myChart'));
    chart.draw(data, google.charts.Bar.convertOptions(options));

    window.addEventListener('resize', function() {
        chart.draw(data, google.charts.Bar.convertOptions(options));
    });
}
</script>