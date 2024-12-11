<?php
include "./view/home/sideheader.php";
$current_week = date('YW');
$thongke_phim = thongke_phim_theo_tuan($current_week, $rap_id);

// Lấy ngày đầu và cuối của tuần
$year = substr($current_week, 0, 4);
$week = substr($current_week, 4);
$dto = new DateTime();
$dto->setISODate($year, $week);
$start_date = $dto->format('d/m/Y');
$dto->modify('+6 days');
$end_date = $dto->format('d/m/Y');
?>

<div class="content-body">
    <!-- Form lọc -->
    <link rel="stylesheet" href="assets/css/stylecolor.css">
    <div class="row mb-4">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="GET" class="row">
                        <input type="hidden" name="act" value="baocao_tuan">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn ngày trong tuần</label>
                                <input type="date" name="ngay" class="form-control" 
                                    value="<?= isset($_GET['ngay']) ? $_GET['ngay'] : date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn rạp</label>
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

                        <div class="col-md-1">
                            <button type="submit" class="button button-primary" style="margin-top: 30px;">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12">
            <div class="box">
                <div class="box-body" id="printArea">
                    <!-- Header báo cáo -->
                    <div class="text-center mb-4">
                        <h2 style="text-transform: uppercase;">Báo Cáo Doanh Thu Tuần <?=$week?>/<?=$year?></h2>
                        <p>Từ ngày <?=$start_date?> đến ngày <?=$end_date?></p>
                        <?php if(isset($_GET['rap_id']) && $_GET['rap_id'] != ''): 
                            foreach($loadrap as $rap) {
                                if($rap['id'] == $_GET['rap_id']) {
                                    echo "<p>Rạp: ".$rap['tenrap']."</p>";
                                    echo "<p>Địa chỉ: ".$rap['diachi']."</p>";
                                    break;
                                }
                            }
                        else: ?>
                            <p>Báo cáo tổng hợp tất cả các rạp</p>
                        <?php endif; ?>
                    </div>

                    <!-- Thống kê doanh thu -->
                    <div class="mb-4">
                        <h4>1. Thống kê doanh thu tuần</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tổng số vé đã bán</th>
                                    <th>Tổng doanh thu</th>
                                    <th>Trung bình/ngày</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total_ve = 0;
                                $total_dt = 0;
                                foreach($thongke_phim as $item) {
                                    $total_ve += $item['so_luong_ve_dat'];
                                    $total_dt += $item['sum_thanhtien'];
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><?= number_format($total_ve) ?> vé</td>
                                    <td class="text-center"><?= number_format($total_dt) ?> VNĐ</td>
                                    <td class="text-center"><?= number_format($total_dt/7) ?> VNĐ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Top phim bán chạy -->
                    <div class="mb-4">
                        <h4>2. Top 5 phim bán chạy nhất tuần</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phim</th>
                                    <th>Thể loại</th>
                                    <th>Rạp chiếu</th>
                                    <th>Số vé đã bán</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 0;
                                foreach($thongke_phim as $phim): 
                                    if($count < 5 && $phim['so_luong_ve_dat'] > 0):
                                        $count++;
                                        $ty_le = ($phim['sum_thanhtien']/$total_dt)*100;
                                ?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$phim['tieu_de']?></td>
                                    <td><?=$phim['ten_loaiphim']?></td>
                                    <td><?=$phim['tenrap']?></td>
                                    <td class="text-right"><?=number_format($phim['so_luong_ve_dat'])?> vé</td>
                                    <td class="text-right"><?=number_format($phim['sum_thanhtien'])?> VNĐ</td>
                                    <td class="text-right"><?=number_format($ty_le,1)?>%</td>
                                </tr>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Phim có doanh thu thấp -->
                    <div class="mb-4">
                        <h4>3. Phim có doanh thu thấp trong tuần (Dưới 5% tổng doanh thu)</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phim</th>
                                    <th>Thể loại</th>
                                    <th>Rạp chiếu</th>
                                    <th>Số vé đã bán</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 0;
                                foreach($thongke_phim as $phim): 
                                    $ty_le = ($phim['sum_thanhtien']/$total_dt)*100;
                                    if($ty_le < 5 && $phim['so_luong_ve_dat'] > 0):
                                        $count++;
                                ?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$phim['tieu_de']?></td>
                                    <td><?=$phim['ten_loaiphim']?></td>
                                    <td><?=$phim['tenrap']?></td>
                                    <td class="text-right"><?=number_format($phim['so_luong_ve_dat'])?> vé</td>
                                    <td class="text-right"><?=number_format($phim['sum_thanhtien'])?> VNĐ</td>
                                    <td class="text-right"><?=number_format($ty_le,1)?>%</td>
                                </tr>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Thống kê theo rạp -->
                    <?php if(!$rap_id): ?>
                    <div class="mb-4">
                        <h4>4. Phim bán chạy nhất theo từng rạp</h4>
                        <?php
                        $phim_theo_rap = array();
                        foreach($thongke_phim as $phim) {
                            if (!isset($phim_theo_rap[$phim['tenrap']]) || 
                                $phim['so_luong_ve_dat'] > $phim_theo_rap[$phim['tenrap']]['so_luong_ve_dat']) {
                                $phim_theo_rap[$phim['tenrap']] = $phim;
                            }
                        }
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rạp</th>
                                    <th>Phim bán chạy nhất</th>
                                    <th>Thể loại</th>
                                    <th>Số vé đã bán</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($phim_theo_rap as $rap => $phim): 
                                    $ty_le = ($phim['sum_thanhtien']/$total_dt)*100;
                                ?>
                                <tr>
                                    <td><?=$rap?></td>
                                    <td><?=$phim['tieu_de']?></td>
                                    <td><?=$phim['ten_loaiphim']?></td>
                                    <td class="text-right"><?=number_format($phim['so_luong_ve_dat'])?> vé</td>
                                    <td class="text-right"><?=number_format($phim['sum_thanhtien'])?> VNĐ</td>
                                    <td class="text-right"><?=number_format($ty_le,1)?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    <!-- Chữ ký -->
                    <div class="row mt-5">
                        <div class="col-6 text-center">
                            <p>Người lập báo cáo</p>
                            <p class="mt-5">(Ký và ghi rõ họ tên)</p>
                        </div>
                        <div class="col-6 text-center">
                            <p>Xác nhận của quản lý</p>
                            <p class="mt-5">(Ký và ghi rõ họ tên)</p>
                        </div>
                    </div>
                </div>

                <!-- Nút in báo cáo -->
                <div class="box-footer text-right">
                    <button onclick="window.print()" class="button button-primary">
                        <i class="fa fa-print"></i> In báo cáo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .adomx-header,
    .side-header,
    .box-footer {
        display: none !important;
    }
    .content-body {
        margin: 0 !important;
        padding: 0 !important;
    }
    .box {
        box-shadow: none !important;
    }
    @page {
        margin: 2cm;
    }
}
.text-right {
    text-align: right;
}
.text-center {
    text-align: center;
}
</style>