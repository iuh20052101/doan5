<?php
include "./view/home/sideheader.php";

// Lấy tháng và năm từ form nếu có, nếu không lấy tháng năm hiện tại
$current_month = isset($_GET['thang']) ? $_GET['thang'] : date('m');
$current_year = isset($_GET['nam']) ? $_GET['nam'] : date('Y');
$rap_id = isset($_GET['rap_id']) ? $_GET['rap_id'] : null;

// Lấy dữ liệu thống kê với tháng và năm đã chọn
$thongke_phim = thongke_phim_theo_thang($current_month, $current_year, $rap_id);

// Lấy tên tháng tiếng Việt
$month_names = array(
    1 => 'Một', 2 => 'Hai', 3 => 'Ba', 4 => 'Tư', 
    5 => 'Năm', 6 => 'Sáu', 7 => 'Bảy', 8 => 'Tám', 
    9 => 'Chín', 10 => 'Mười', 11 => 'Mười Một', 12 => 'Mười Hai'
);
?>
<!-- Thêm phần form lọc vào đầu file, sau phần header -->
<div class="content-body">
    <!-- Form lọc -->
    <link rel="stylesheet" href="assets/css/stylecolor.css">
    <div class="row mb-4">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="GET" class="row">
                        <input type="hidden" name="act" value="baocao_thang">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn tháng</label>
                                <select name="thang" class="form-control">
                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?=$i?>" <?=($i == $current_month) ? 'selected' : ''?>>
                                            Tháng <?=$i?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn năm</label>
                                <select name="nam" class="form-control">
                                    <?php 
                                    $year_now = date('Y');
                                    for($i = $year_now; $i >= $year_now - 2; $i--): 
                                    ?>
                                        <option value="<?=$i?>" <?=($i == $current_year) ? 'selected' : ''?>>
                                            Năm <?=$i?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
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

    <!-- Phần nội dung báo cáo giữ nguyên -->
<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12">
            <div class="box">
                <div class="box-body" id="printArea">
                    <!-- Header báo cáo -->
                    <div class="text-center mb-4">
                        <h2 style="text-transform: uppercase;">Báo Cáo Doanh Thu Tháng <?=$month_names[$current_month]?> Năm <?=$current_year?></h2>
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
                        <h4>1. Thống kê doanh thu tháng</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tổng số vé đã bán</th>
                                    <th>Tổng doanh thu</th>
                                    <th>Trung bình/ngày</th>
                                    <th>So với tháng trước</th>
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
                                
                                // Lấy số ngày trong tháng
                                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
                                
                                // Tính doanh thu tháng trước
                                $prev_month = $current_month - 1;
                                $prev_year = $current_year;
                                if($prev_month == 0) {
                                    $prev_month = 12;
                                    $prev_year--;
                                }
                                $prev_data = thongke_phim_theo_thang($prev_month, $prev_year, $rap_id);
                                $prev_total = 0;
                                foreach($prev_data as $item) {
                                    $prev_total += $item['sum_thanhtien'];
                                }
                                
                                // Tính phần trăm tăng/giảm
                                $percent_change = 0;
                                if($prev_total > 0) {
                                    $percent_change = (($total_dt - $prev_total) / $prev_total) * 100;
                                }
                                ?>
                                <tr>
                                    <td class="text-center"><?= number_format($total_ve) ?> vé</td>
                                    <td class="text-center"><?= number_format($total_dt) ?> VNĐ</td>
                                    <td class="text-center"><?= number_format($total_dt/$days_in_month) ?> VNĐ</td>
                                    <td class="text-center <?= $percent_change >= 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= $percent_change >= 0 ? '+' : '' ?><?= number_format($percent_change, 1) ?>%
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Top phim bán chạy -->
                    <div class="mb-4">
                        <h4>2. Top 10 phim bán chạy nhất tháng</h4>
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
                                    if($count < 10 && $phim['so_luong_ve_dat'] > 0):
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

                    <!-- Phân tích theo thể loại -->
                    <div class="mb-4">
                        <h4>3. Phân tích doanh thu theo thể loại phim</h4>
                        <?php
                        $theloai = array();
                        foreach($thongke_phim as $phim) {
                            if(!isset($theloai[$phim['ten_loaiphim']])) {
                                $theloai[$phim['ten_loaiphim']] = array(
                                    'so_phim' => 0,
                                    'so_ve' => 0,
                                    'doanh_thu' => 0
                                );
                            }
                            $theloai[$phim['ten_loaiphim']]['so_phim']++;
                            $theloai[$phim['ten_loaiphim']]['so_ve'] += $phim['so_luong_ve_dat'];
                            $theloai[$phim['ten_loaiphim']]['doanh_thu'] += $phim['sum_thanhtien'];
                        }
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Thể loại</th>
                                    <th>Số lượng phim</th>
                                    <th>Số vé bán ra</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($theloai as $ten_loai => $data): 
                                    $ty_le = $total_dt > 0 ? ($data['doanh_thu']/$total_dt)*100 : 0;
                                ?>
                                <tr>
                                    <td><?=$ten_loai?></td>
                                    <td class="text-center"><?=$data['so_phim']?></td>
                                    <td class="text-right"><?=number_format($data['so_ve'])?> vé</td>
                                    <td class="text-right"><?=number_format($data['doanh_thu'])?> VNĐ</td>
                                    <td class="text-right"><?=number_format($ty_le,1)?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Thống kê theo rạp -->
                    <?php if(!$rap_id): ?>
                    <div class="mb-4">
                        <h4>4. Thống kê theo từng rạp</h4>
                        <?php
                        $doanh_thu_rap = array();
                        foreach($thongke_phim as $phim) {
                            if(!isset($doanh_thu_rap[$phim['tenrap']])) {
                                $doanh_thu_rap[$phim['tenrap']] = array(
                                    'so_phim' => 0,
                                    'so_ve' => 0,
                                    'doanh_thu' => 0,
                                    'phim_hot' => ''
                                );
                            }
                            $doanh_thu_rap[$phim['tenrap']]['so_phim']++;
                            $doanh_thu_rap[$phim['tenrap']]['so_ve'] += $phim['so_luong_ve_dat'];
                            $doanh_thu_rap[$phim['tenrap']]['doanh_thu'] += $phim['sum_thanhtien'];
                            if($phim['so_luong_ve_dat'] > 0 && 
                               ($doanh_thu_rap[$phim['tenrap']]['phim_hot'] == '' || 
                                $phim['so_luong_ve_dat'] > $doanh_thu_rap[$phim['tenrap']]['so_ve_hot'])) {
                                $doanh_thu_rap[$phim['tenrap']]['phim_hot'] = $phim['tieu_de'];
                                $doanh_thu_rap[$phim['tenrap']]['so_ve_hot'] = $phim['so_luong_ve_dat'];
                            }
                        }
                        ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Rạp</th>
                                    <th>Số phim chiếu</th>
                                    <th>Tổng số vé</th>
                                    <th>Doanh thu</th>
                                    <th>Tỷ lệ (%)</th>
                                    <th>Phim bán chạy nhất</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($doanh_thu_rap as $rap => $data): 
                                    $ty_le = $total_dt > 0 ? ($data['doanh_thu']/$total_dt)*100 : 0;
                                ?>
                                <tr>
                                    <td><?=$rap?></td>
                                    <td class="text-center"><?=$data['so_phim']?></td>
                                    <td class="text-right"><?=number_format($data['so_ve'])?> vé</td>
                                    <td class="text-right"><?=number_format($data['doanh_thu'])?> VNĐ</td>
                                    <td class="text-right"><?=number_format($ty_le,1)?>%</td>
                                    <td><?=$data['phim_hot']?></td>
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
.text-success {
    color: #28a745;
}
.text-danger {
    color: #dc3545;
}
</style>