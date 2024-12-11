<?php
include "./view/home/sideheader.php";

?>


<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Theo Dõi Doanh Thu <span>/ Doanh Thu Theo Phim</span></h3>
            </div>
        </div>
    </div>
    <div class="row mb-20">
        <div class="col-12">
            <form action="" method="GET" class="row">
                <input type="hidden" name="act" value="DTphim">
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
                    <h3 class="title">Thống kê doanh thu theo phim</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered data-table data-table-default">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Phim</th>
                                <th>Thể Loại</th>
                                <th>Số Lượng Vé Đã Bán</th>
                                <th>Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($dtt) && is_array($dtt)) {
                                foreach ($dtt as $item) {
                            ?>
                                <tr>
                                    <td><?= isset($item['id']) ? $item['id'] : '' ?></td>
                                    <td><?= isset($item['tieu_de']) ? $item['tieu_de'] : '' ?></td>
                                    <td><?= isset($item['ten_loaiphim']) ? $item['ten_loaiphim'] : '' ?></td>
                                    <td><?= isset($item['so_luong_ve_dat']) ? number_format($item['so_luong_ve_dat']) : 0 ?></td>
                                    <td><?= isset($item['sum_thanhtien']) ? number_format($item['sum_thanhtien']) : 0 ?> VNĐ</td>
                                </tr>
                            <?php 
                                }
                            } 
                            ?>
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
                    <?php if(isset($dtt1) && is_array($dtt1)): ?>
                    <ul class="pagination">
                        <?php 
                        $tong = count($dtt1);
                        $trang = ceil($tong/5);
                        for($i=1; $i<=$trang; $i++):
                        ?>
                        <li class="page-item <?=isset($_GET['trang']) && $_GET['trang']==$i ? 'active' : ''?>">
                            <a class="page-link" href="index.php?act=DTphim&trang=<?=$i?>">
                                <?=$i?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ -->
    <div class="row">
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Biểu đồ doanh thu và số vé bán theo phim</h3>
                </div>
                <div class="box-body">
                    <div id="myChart" style="width:100%; min-height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
google.charts.load('current', {'packages':['corechart', 'bar']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Phim');
    data.addColumn('number', 'Doanh Thu');
    data.addColumn('number', 'Số Vé Bán');

    data.addRows([
        <?php
        if(isset($dtt) && is_array($dtt)) {
            foreach ($dtt as $item) {
                if(isset($item['tieu_de']) && isset($item['sum_thanhtien']) && isset($item['so_luong_ve_dat'])) {
                    echo "['".$item['tieu_de']."', "
                        .(int)$item['sum_thanhtien'].", "
                        .(int)$item['so_luong_ve_dat']."],\n";
                }
            }
        }
        ?>
    ]);

    var options = {
        title: 'BIỂU ĐỒ DOANH THU VÀ SỐ VÉ BÁN THEO PHIM',
        width: '100%',
        height: 500,
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: false,
        backgroundColor: 'transparent',
        chartArea: {width: '80%', height: '70%'},
        titleTextStyle: {
            color: '#333',
            fontSize: 18,
            bold: true
        },
        vAxes: {
            0: {
                title: 'Doanh Thu (VNĐ)',
                format: 'short',
                textStyle: {color: '#333'}
            },
            1: {
                title: 'Số Vé Bán',
                format: '#,###',
                textStyle: {color: '#333'}
            }
        },
        series: {
            0: {targetAxisIndex: 0, color: '#4285F4'},
            1: {targetAxisIndex: 1, color: '#34A853'}
        },
        hAxis: {
            textStyle: {
                color: '#333',
                fontSize: 12,
                bold: false
            },
            slantedText: true,
            slantedTextAngle: 45
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('myChart'));
    chart.draw(data, options);

    // Responsive
    window.addEventListener('resize', function() {
        chart.draw(data, options);
    });
}
</script>