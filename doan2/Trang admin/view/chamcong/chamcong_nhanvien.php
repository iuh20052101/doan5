<?php 
include "./view/home/sideheader.php";
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

<style>
/* Thêm style cho sideheader */
.sideheader {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050; /* Đảm bảo sideheader luôn nổi lên trên */
}

/* Điều chỉnh content để không bị đè */
.chamcong-content {
    margin-top: 50px;
    margin-left: 270px; /* Thêm margin-left tương ứng với width của sideheader */
    padding: 20px;
    background: #F4F5F9;
    min-height: calc(100vh - 200px);
    position: relative;
    z-index: 1000;
}

/* Thêm style cho icons */
.fas {
    width: 20px;
    text-align: center;
}

.fa-user { color: #2196F3; }
.fa-film { color: #673AB7; }
.fa-clock { color: #4CAF50; }
.fa-chart-bar { color: #FF9800; }
.fa-info-circle { color: #03A9F4; }
.fa-filter { color: #fff; }
.fa-check { color: #fff; }
.fa-edit { color: #fff; }
.fa-tasks { color: #009688; }
.fa-building { color: #3F51B5; }

/* Giữ nguyên phần style */
</style>

<div class="chamcong-content">
<!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->

    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-12 col-lg-auto">
            <div class="page-heading">
                <h3 class="mb-0">Chấm công nhân viên</h3>
            </div>
        </div>
    </div>

    <!-- Form lọc -->
    <div class="filter-card">
        <form method="GET" class="mb-0">
            <input type="hidden" name="act" value="chamcong_nhanvien">
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label>Chọn rạp</label>
                    <select name="rap" class="form-control">
                        <option value="">Tất cả rạp</option>
                        <?php foreach($dsRap as $rap): ?>
                            <option value="<?= $rap['id'] ?>" 
                                <?= isset($_GET['rap']) && $_GET['rap'] == $rap['id'] ? 'selected' : '' ?>>
                                <?= $rap['tenrap'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Chọn tháng</label>
                    <input type="month" name="thang" class="form-control" 
                           value="<?= isset($_GET['thang']) ? $_GET['thang'] : date('Y-m') ?>">
                </div>
                <div class="col-md-3">
                    <label>Chọn ngày</label>
                    <input type="date" name="ngay" class="form-control" 
                           value="<?= isset($_GET['ngay']) ? $_GET['ngay'] : date('Y-m-d') ?>">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-success w-100" onclick="exportExcel()">
                        <i class="fas fa-file-excel mr-2"></i>Xuất Excel
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter mr-2"></i>Xem lịch
                    </button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <!-- Bảng chấm công -->
    <div class="filter-card">
        <div class="table-responsive">
            <h4 class="mb-4">Chấm công nhân viên ngày <?= date('d/m/Y') ?></h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th>Rạp</th>
                        <th>Ca làm việc</th>
                        <th>Công việc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($dsLichLamViec as $lich): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user mr-2"></i>
                                <?= $lich['ten_nhanvien'] ?>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-film mr-2"></i>
                            <?= $lich['tenrap'] ?>
                        </td>
                        <td>
                            <i class="fas fa-clock mr-2"></i>
                            <?= $lich['ca_lam_viec'] ?>
                        </td>
                        <td><?= $lich['ten_cong_viec'] ?></td>
                        <td>
                            <span class="badge badge-<?= getTrangThaiBadgeClass($lich['trang_thai_cham_cong']) ?>">
                                <?= $lich['trang_thai_cham_cong'] ?>
                            </span>
                        </td>
                        <td>
                            <form action="index.php?act=xu_ly_chamcong" method="POST" class="d-inline">
                                <input type="hidden" name="id_lichlamviec" value="<?= $lich['id'] ?>">
                                <input type="hidden" name="redirect" value="chamcong_nhanvien">
                                <div class="d-flex align-items-center">
                                    <select name="trang_thai" class="form-control mr-2" style="width: auto">
                                        <option value="đúng giờ" <?= $lich['trang_thai_cham_cong'] == 'đúng giờ' ? 'selected' : '' ?>>
                                            Đúng giờ
                                        </option>
                                        <option value="đi trễ" <?= $lich['trang_thai_cham_cong'] == 'đi trễ' ? 'selected' : '' ?>>
                                            Đi trễ
                                        </option>
                                        <option value="vắng" <?= $lich['trang_thai_cham_cong'] == 'vắng' ? 'selected' : '' ?>>
                                            Vắng
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-sm <?= $lich['trang_thai_cham_cong'] == 'chưa chấm công' ? 'btn-primary' : 'btn-warning' ?>">
                                        <i class="fas fa-<?= $lich['trang_thai_cham_cong'] == 'chưa chấm công' ? 'check' : 'edit' ?> mr-1"></i>
                                        <?= $lich['trang_thai_cham_cong'] == 'chưa chấm công' ? 'Chấm công' : 'Cập nhật' ?>
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Thống kê -->
    <div class="stats-card">
        <h4>
            <i class="fas fa-chart-bar mr-2"></i>
            Thống kê tháng <?= isset($_GET['thang']) ? date('m/Y', strtotime($_GET['thang'])) : date('m/Y') ?>
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nhân viên</th>
                        <th class="text">Tổng ca</th>
                        <th class="text">Đúng giờ</th>
                        <th class="text">Đi trễ</th>
                        <th class="text">Vắng</th>
                        <th class="text">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($thongKe as $tk): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user mr-2"></i>
                                <?= $tk['ten_nhanvien'] ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="stats-number"><?= $tk['tong_ca'] ?></span>
                        </td>
                        <td class="text-center">
                            <span class="stats-number text-success"><?= $tk['dung_gio'] ?></span>
                        </td>
                        <td class="text-center">
                            <span class="stats-number text-warning"><?= $tk['di_tre'] ?></span>
                        </td>
                        <td class="text-center">
                            <span class="stats-number text-danger"><?= $tk['vang'] ?></span>
                        </td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm" 
                                    data-toggle="modal" 
                                    data-target="#modalChiTiet_<?= str_replace(' ', '_', $tk['ten_nhanvien']) ?>">
                                <i class="fas fa-info-circle mr-2"></i>Chi tiết
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Thêm style mới -->
    <style>
    .stats-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        padding: 25px;
        margin-bottom: 25px;
    }

    .stats-card h4 {
        color: #1a237e;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e3f2fd;
    }

    .stats-number {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .badge {
        padding: 8px 15px;
        font-weight: 500;
        border-radius: 30px;
    }

    .badge-success {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .badge-warning {
        background: #fff3e0;
        color: #f57f17;
    }

    .badge-danger {
        background: #ffebee;
        color: #c62828;
    }

    .btn-info {
        background: #1976d2;
        border-color: #1976d2;
    }

    .btn-info:hover {
        background: #1565c0;
        border-color: #1565c0;
    }

    /* Thêm style cho thống kê rạp */
    .rap-stats {
        background: #f5f5f5;
        border-radius: 10px;
        padding: 15px;
        margin-top: 10px;
    }

    .rap-title {
        color: #1a237e;
        font-weight: 600;
        margin-bottom: 15px;
    }
    </style>


<!-- Style cho modal chi tiết -->
<style>
.modal-lg {
    max-width: 1000px;
}

.modal-header {
    background: #2196F3;
    color: white;
    padding: 15px 20px;
    margin-left:30px;
}

.modal-title {
    font-size: 1.2rem;
    font-weight: 600;
}

.modal-body {
    padding: 20px;
}

.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 20px;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 10px 15px;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #2196F3;
    border-bottom: 2px solid #2196F3;
    font-weight: 600;
}

.tab-content {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.table thead th {
    background: #e9ecef;
    border-bottom: 2px solid #dee2e6;
}

.badge {
    padding: 8px 12px;
    font-size: 0.9rem;
}

.stats-number {
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-sm {
    padding: 5px 10px;
}

.alert {
    margin-bottom: 0;
    padding: 15px;
}

/* Reset lại z-index */
.modal-backdrop {
    display: none;
}

.modal {
    background: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    margin: 30px auto;
}

.modal-content {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
}

/* Đảm bảo form trong modal hoạt động */
.modal .form-control,
.modal .btn,
.modal select {
    position: relative;
}

/* Style cho tabs */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 10px 15px;
}

.nav-tabs .nav-link.active {
    color: #2196F3;
    border-bottom: 2px solid #2196F3;
}
</style>

<!-- Đặt modal ở cuối file, trước đóng body -->
<?php foreach($thongKe as $tk): 
    if($tk['ten_nhanvien'] != NULL): // Sửa điều kiện kiểm tra
?>
    <div class="modal fade" id="modalChiTiet_<?= str_replace(' ', '_', $tk['ten_nhanvien']) ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-clock mr-2"></i>
                        Chi tiết chấm công - <?= $tk['ten_nhanvien'] ?>
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Thêm form chọn tháng -->
                    <form method="GET" class="mb-3">
                        <input type="hidden" name="act" value="chamcong_nhanvien">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="mb-0 mr-2">Chọn tháng:</label>
                            </div>
                            <div class="col-md-6">
                                <input type="month" name="thang" class="form-control" 
                                       value="<?= isset($_GET['thang']) ? $_GET['thang'] : date('Y-m') ?>"
                                       onchange="this.form.submit()">
                            </div>
                        </div>
                    </form>

                    <!-- Tabs cho từng ngày -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php 
                        $thang_xem = isset($_GET['thang']) ? date('m', strtotime($_GET['thang'])) : date('m');
                        $nam_xem = isset($_GET['thang']) ? date('Y', strtotime($_GET['thang'])) : date('Y');
                        $ngay_trong_thang = cal_days_in_month(CAL_GREGORIAN, $thang_xem, $nam_xem);
                        
                        for($i = 1; $i <= $ngay_trong_thang; $i++): 
                            $ngay = date('Y-m-', strtotime("$nam_xem-$thang_xem-01")) . sprintf("%02d", $i);
                        ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $i == date('d') && $thang_xem == date('m') ? 'active' : '' ?>" 
                                   data-toggle="tab" 
                                   href="#ngay<?= $i ?>_<?= str_replace(' ', '_', $tk['ten_nhanvien']) ?>">
                                    <?= $i ?>/<?= $thang_xem ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>

                    <!-- Nội dung tab -->
                    <div class="tab-content">
                        <?php for($i = 1; $i <= $ngay_trong_thang; $i++): 
                            $ngay = date('Y-m-', strtotime("$nam_xem-$thang_xem-01")) . sprintf("%02d", $i);
                            $chi_tiet_ngay = array_filter($tk['chi_tiet'], function($item) use ($ngay) {
                                return $item['ngay_lam_viec'] == $ngay;
                            });
                        ?>
                            <div class="tab-pane fade <?= $i == date('d') ? 'show active' : '' ?>" 
                                 id="ngay<?= $i ?>_<?= str_replace(' ', '_', $tk['ten_nhanvien']) ?>">
                                <?php if(!empty($chi_tiet_ngay)): ?>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">Ca làm việc</th>
                                                <th style="width: 20%">Rạp</th>
                                                <th style="width: 20%">Công việc</th>
                                                <th style="width: 20%">Trạng thái</th>
                                                <th style="width: 20%">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($chi_tiet_ngay as $ct): ?>
                                            <tr>
                                                <td>
                                                    <i class="fas fa-clock mr-2 text-primary"></i>
                                                    <?= $ct['ca_lam_viec'] ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-film mr-2 text-info"></i>
                                                    <?= $ct['tenrap'] ?>
                                                </td>
                                                <td>
                                                    <i class="fas fa-tasks mr-2 text-success"></i>
                                                    <?= $ct['ten_cong_viec'] ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?= getTrangThaiBadgeClass($ct['trang_thai_cham_cong']) ?>">
                                                        <?= $ct['trang_thai_cham_cong'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="index.php?act=xu_ly_chamcong" method="POST">
                                                        <input type="hidden" name="id_lichlamviec" value="<?= $ct['id'] ?>">
                                                        <input type="hidden" name="redirect" value="chamcong_nhanvien">
                                                        <select name="trang_thai" class="form-control form-control-sm mb-2">
                                                            <option value="đúng giờ" <?= $ct['trang_thai_cham_cong'] == 'đúng giờ' ? 'selected' : '' ?>>
                                                                Đúng giờ
                                                            </option>
                                                            <option value="đi trễ" <?= $ct['trang_thai_cham_cong'] == 'đi trễ' ? 'selected' : '' ?>>
                                                                Đi trễ
                                                            </option>
                                                            <option value="vng" <?= $ct['trang_thai_cham_cong'] == 'vắng' ? 'selected' : '' ?>>
                                                                Vắng
                                                            </option>
                                                        </select>
                                                        <button type="submit" class="btn btn-sm btn-block <?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'btn-primary' : 'btn-warning' ?>">
                                                            <i class="fas fa-<?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'check' : 'edit' ?> mr-1"></i>
                                                            <?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'Chấm công' : 'Cập nhật' ?>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Không có ca làm việc trong ngày này
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    endif;
endforeach; 
?>

<!-- Thêm script để khởi tạo tabs -->
<script>
$(document).ready(function() {
    // Khởi tạo tabs khi modal mở
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('.nav-tabs a:first').tab('show');
    });

    // Xử lý chuyển tab
    $('.nav-tabs a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});
</script>

<!-- Thêm script xuất Excel -->
<script>
function exportExcel() {
    let url = 'index.php?act=export_chamcong_nhanvien';
    
    // Thêm các tham số lọc
    if ($('select[name="rap"]').val()) {
        url += '&rap=' + $('select[name="rap"]').val();
    }
    if ($('input[name="thang"]').val()) {
        url += '&thang=' + $('input[name="thang"]').val();
    }
    if ($('input[name="ngay"]').val()) {
        url += '&ngay=' + $('input[name="ngay"]').val();
    }
    
    window.location.href = url;
}
</script>
