<?php include "./view/home/sideheader.php"; ?>

<div class="content-body">
    <!-- Tiêu đề trang -->
    <link rel="stylesheet" href="assets/css/stylecolor.css">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Bảng Lương Quản Lý <span>/ Tháng <?= $thang ?>/<?= $nam ?></span></h3>
            </div>
        </div>
    </div>

    <!-- Form lọc -->
    <div class="row mb-20">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form action="" method="GET" class="row">
                        <input type="hidden" name="act" value="bangluong_quanly">
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
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng lương quản lý -->
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Bảng Lương Quản Lý</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Họ Tên</th>
                                <th>Số Ngày Làm</th>
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
                            <?php foreach($luongQuanLy as $item): ?>
                            <tr>
                                <td><?= $item['thong_tin']['name'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_ngay_lam'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_lan_vang'] ?></td>
                                <td><?= $item['luong']['chi_tiet']['so_lan_tre'] ?></td>
                                <td><?= number_format($item['luong']['luong_co_ban']) ?></td>
                                <td><?= number_format($item['luong']['thuong_chuyen_can']) ?></td>
                                <td><?= number_format($item['luong']['tien_phat']) ?></td>
                                <td><?= number_format($item['luong']['tong_luong']) ?></td>
                                <td>
                                    <button class="button button-info" onclick="showChiTiet('ql',<?= $item['thong_tin']['id'] ?>)">
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
function showChiTiet(loai, id) {
    let html = `
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>`;

    <?php
    // Chuẩn bị dữ liệu cho quản lý
    $dataQL = [];
    foreach($luongQuanLy as $ql) {
        $ngay_dau_thang = "$nam-$thang-01";
        $so_ngay = date('t', strtotime($ngay_dau_thang));
        $chitiet = [];
        
        $sql = "SELECT ngay_lam_viec, trang_thai_cham_cong 
                FROM lichlamviec 
                WHERE id_taikhoan = ? 
                AND MONTH(ngay_lam_viec) = ?
                AND YEAR(ngay_lam_viec) = ?";
        $data_chamcong = pdo_query($sql, $ql['thong_tin']['id'], $thang, $nam);
        
        $data_theo_ngay = [];
        foreach($data_chamcong as $item) {
            $data_theo_ngay[date('Y-m-d', strtotime($item['ngay_lam_viec']))] = $item;
        }
        
        for($i = 1; $i <= $so_ngay; $i++) {
            $ngay = sprintf("%s-%s-%02d", $nam, $thang, $i);
            
            if(isset($data_theo_ngay[$ngay])) {
                $chitiet[] = $data_theo_ngay[$ngay];
            } else {
                $chitiet[] = [
                    'ngay_lam_viec' => $ngay,
                    'trang_thai_cham_cong' => 'chưa chấm công'
                ];
            }
        }
        
        $dataQL[$ql['thong_tin']['id']] = $chitiet;
    }
    ?>

    const dataQL = <?= json_encode($dataQL) ?>;
    let data = dataQL[id];
    let thongke = {
        so_lan_vang: 0,
        so_lan_tre: 0
    };
    
    data.forEach(item => {
        const ngayObj = new Date(item.ngay_lam_viec);
        const ngay = ngayObj.toLocaleDateString('vi-VN');
        const thu = ngayObj.getDay();
        let mauTrangThai = '';
        
        switch(item.trang_thai_cham_cong) {
            case 'có mặt':
                mauTrangThai = 'success';
                break;
            case 'vắng':
                mauTrangThai = 'danger';
                thongke.so_lan_vang++;
                break;
            case 'đi trễ':
                mauTrangThai = 'warning';
                thongke.so_lan_tre++;
                break;
            case 'chưa chấm công':
                mauTrangThai = 'secondary';
                break;
        }

        html += `
        <tr ${thu === 0 || thu === 6 ? 'class="table-secondary"' : ''}>
            <td>${ngay} ${thu === 0 ? '(CN)' : thu === 6 ? '(T7)' : ''}</td>
            <td>
                <span class="badge badge-${mauTrangThai}">
                    ${item.trang_thai_cham_cong.charAt(0).toUpperCase() + item.trang_thai_cham_cong.slice(1)}
                </span>
            </td>
        </tr>`;
    });

    html += `
            </tbody>
        </table>
        <div class="mt-3">
            <h5>Thống kê:</h5>
            <ul class="list-unstyled">
                <li>Tổng số ngày: <strong>${data.length} ngày</strong></li>
                <li>Số lần vắng: <strong class="text-danger">${thongke.so_lan_vang}</strong></li>
                <li>Số lần đi trễ: <strong class="text-warning">${thongke.so_lan_tre}</strong></li>
            </ul>
        </div>
    </div>`;

    $('#chiTietData').html(html);
    $('#modalChiTiet').modal('show');
}

function exportExcel() {
    let url = 'index.php?act=export_bangluong_quanly&thang=<?= $thang ?>&nam=<?= $nam ?>';
    window.location.href = url;
}
</script>