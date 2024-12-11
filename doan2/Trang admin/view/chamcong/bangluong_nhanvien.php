<?php
include "./view/home/sideheader.php";?>
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">
    <!-- Tiêu đề trang -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Bảng Lương Nhân Viên <span>/ Tháng <?= $thang ?>/<?= $nam ?></span></h3>
            </div>
        </div>
    </div>

    <!-- Form lọc -->
    <div class="row mb-20">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="GET" class="row">
                        <input type="hidden" name="act" value="bangluong_nhanvien">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn Rạp</label>
                                <select name="rap" class="form-control">
                                    <option value="">Tất cả rạp</option>
                                    <?php foreach($dsRap as $rap): ?>
                                        <option value="<?=$rap['id']?>" <?=isset($_GET['rap']) && $_GET['rap']==$rap['id'] ? 'selected' : ''?>>
                                            <?=$rap['tenrap']?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Chọn Tháng</label>
                                <input type="month" name="thang" class="form-control" 
                                       value="<?= isset($_GET['thang']) ? $_GET['thang'] : date('Y-m') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="button button-primary" style="margin-top: 30px;">
                                <i class="fa fa-filter"></i> Lọc
                            </button>
                            <button type="button" class="button button-success" style="margin-top: 30px;" onclick="exportExcel()">
                                <i class="fa fa-file-excel"></i> Xuất Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng lương nhân viên -->
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Bảng Lương Nhân Viên</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Họ Tên</th>
                                <th>Số Ca Làm</th>
                                <th>Số Lần Vắng</th>
                                <th>Số Lần Trễ</th>
                                <th>Lương Cơ Bản</th>
                                <th>Thưởng Chuyên Cần</th>
                                <th>Tiền Phạt</th>
                                <th>Tổng Lương</th>
                                <th>Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($luongNhanVien as $item): ?>
                            <tr>
                                <td><?= $item['thong_tin']['ten_nhanvien'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_ca_lam'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_lan_vang'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_lan_tre'] ?></td>
                                <td><?= number_format($item['luong']['luong_co_ban']) ?></td>
                                <td><?= number_format($item['luong']['thuong_chuyen_can']) ?></td>
                                <td><?= number_format($item['luong']['tien_phat']) ?></td>
                                <td><?= number_format($item['luong']['tong_luong']) ?></td>
                                <td>
                                    <button class="button button-info" onclick="showChiTiet('<?= htmlspecialchars($item['thong_tin']['ten_nhanvien'], ENT_QUOTES) ?>')">
                                        <i class="fa fa-eye"></i> Chi tiết
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal chi tiết -->
<div class="modal fade" id="modalChiTiet">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi Tiết Chấm Công</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="chiTietData"></div>
            </div>
        </div>
    </div>
</div>

<script>
function showChiTiet(ten_nhanvien) {
    let html = `
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Ca làm việc</th>
                    <th>Công việc</th>
                    <th>Trạng thái</th>
                    <th>Lương ca</th>
                </tr>
            </thead>
            <tbody>`;

    <?php
    // Chuẩn bị dữ liệu cho từng nhân viên
    $dataNV = [];
    foreach($luongNhanVien as $nv) {
        $sql = "SELECT ngay_lam_viec, ca_lam_viec, ten_cong_viec, trang_thai_cham_cong
                FROM lichlamviec 
                WHERE ten_nhanvien = ? 
                AND MONTH(ngay_lam_viec) = ?
                AND YEAR(ngay_lam_viec) = ?
                " . (isset($_GET['rap']) && $_GET['rap'] != '' ? "AND id_rap = ?" : "") . "
                ORDER BY ngay_lam_viec ASC, ca_lam_viec ASC";
        
        $params = [$nv['thong_tin']['ten_nhanvien'], $thang, $nam];
        if(isset($_GET['rap']) && $_GET['rap'] != '') {
            $params[] = $_GET['rap'];
        }
        
        $chitiet = pdo_query($sql, ...$params);
        $dataNV[$nv['thong_tin']['ten_nhanvien']] = $chitiet;
    }
    ?>

    const dataNV = <?= json_encode($dataNV) ?>;
    const LUONG_THEO_CONGVIEC = <?= json_encode(LUONG_THEO_CONGVIEC) ?>;
    let data = dataNV[ten_nhanvien] || [];
    let thongke = {
        so_lan_vang: 0,
        so_lan_tre: 0
    };

    if (data.length === 0) {
        html += '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
    } else {
        data.forEach(item => {
            const ngay = new Date(item.ngay_lam_viec).toLocaleDateString('vi-VN');
            let mauTrangThai = 'secondary';
            
            switch(item.trang_thai_cham_cong) {
                case 'đúng giờ':
                    mauTrangThai = 'success';
                    break;
                case 'đi trễ':
                    mauTrangThai = 'warning';
                    thongke.so_lan_tre++;
                    break;
                case 'vắng':
                    mauTrangThai = 'danger';
                    thongke.so_lan_vang++;
                    break;
            }

            html += `
            <tr>
                <td>${ngay}</td>
                <td>${item.ca_lam_viec || ''}</td>
                <td>${item.ten_cong_viec || ''}</td>
                <td>
                    <span class="badge badge-${mauTrangThai}">
                        ${item.trang_thai_cham_cong}
                    </span>
                </td>
                <td>${new Intl.NumberFormat('vi-VN').format(LUONG_THEO_CONGVIEC[item.ten_cong_viec] || 0)} đ</td>
            </tr>`;
        });
    }

    html += `
            </tbody>
        </table>
        <div class="mt-3">
            <h5>Thống kê:</h5>
            <ul class="list-unstyled">
                <li>Tổng số ca làm: <strong>${data.length} ca</strong></li>
                <li>Số lần vắng: <strong class="text-danger">${thongke.so_lan_vang}</strong></li>
                <li>Số lần đi trễ: <strong class="text-warning">${thongke.so_lan_tre}</strong></li>
                ${data.length > 0 ? `
                    <li>Công việc: <strong>${data[0].ten_cong_viec}</strong></li>
                    <li>Mức lương/ca: <strong>${new Intl.NumberFormat('vi-VN').format(LUONG_THEO_CONGVIEC[data[0].ten_cong_viec] || 0)} đ</strong></li>
                ` : ''}
            </ul>
        </div>
    </div>`;

    $('#chiTietData').html(html);
    $('#modalChiTiet').modal('show');
}
</script>