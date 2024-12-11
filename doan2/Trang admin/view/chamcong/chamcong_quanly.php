<?php 
include "./view/home/sideheader.php";

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">


<style>
.chamcong-content {
    margin-left: 300px;
    margin-top: 200px;
    background: #F4F5F9;
    min-height: calc(100vh - 200px);
    padding: 20px;
    transition: all 0.3s;
}

@media (max-width: 991.98px) {
    .chamcong-content {
        margin-left: 0;
    }
}

body.mini-sidebar .chamcong-content {
    margin-left: 65px;
}

.filter-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    padding: 20px;
    margin-bottom: 25px;
}

.rap-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
}

.rap-card .card-header {
    background: #2196F3;
    color: white;
    padding: 15px 20px;
    border-bottom: none;
}

.rap-card .card-body {
    padding: 20px;
}

.table {
    margin-bottom: 0;
}


.badge {
    padding: 8px 12px;
    font-weight: 500;
    border-radius: 30px;
}

.btn-detail {
    background: #2196F3;
    color: white;
    border-radius: 5px;
    padding: 8px 15px;
    transition: all 0.3s;
}

.btn-detail:hover {
    background: #1976D2;
    color: white;
    transform: translateY(-1px);
}

.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.modal-header {
    background: #2196F3;
    color: white;
    border-bottom: none;
}

.modal-body {
    padding: 20px;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 8px 12px;
}

.form-control:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 0.2rem rgba(33,150,243,.25);
}

.stats-number {
    font-size: 18px;
    font-weight: 600;
}

.date-filter {
    display: flex;
    align-items: center;
    gap: 10px;
}

.date-filter label {
    margin-bottom: 0;
    color: #495057;
    font-weight: 500;
}

/* Reset z-index cho modal */
.modal-backdrop {
    display: none;
}

.modal {
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999 !important;
}

.modal-dialog {
    margin: 30px auto;
    z-index: 10000 !important;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
    z-index: 10001 !important;
}

/* Đảm bảo form trong modal hoạt động */
.modal .form-control,
.modal .btn,
.modal select {
    position: relative;
    z-index: 10002 !important;
}

/* Style cho table trong modal */
.modal .table {
    position: relative;
    z-index: 10001 !important;
}

/* Attendance details styling */
.attendance-details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.detail-title {
    color: #2c3e50;
    font-weight: 600;
    font-size: 15px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #dee2e6;
}

.time-label {
    color: #34495e;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 8px;
}

.time-input {
    width: 100% !important;
    height: 38px !important;
    border: 1px solid #dce4ec !important;
    border-radius: 6px !important;
    padding: 8px 12px !important;
    font-size: 14px !important;
}

.time-input:focus {
    border-color: #3498db !important;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25) !important;
}

textarea.form-control {
    resize: none;
    border: 1px solid #dce4ec;
}

textarea.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25);
}

/* Update modal size */
.modal-dialog {
    max-width: 700px !important;
}

/* Badge styling */
.badge {
    font-size: 12px !important;
    padding: 6px 12px !important;
    border-radius: 30px !important;
}

.badge-success {
    background-color: #2ecc71 !important;
}

.badge-warning {
    background-color: #f1c40f !important;
}

.badge-danger {
    background-color: #e74c3c !important;
}

/* Button styling */
.btn-sm {
    padding: 5px 10px !important;
    font-size: 13px !important;
    border-radius: 4px !important;
}

.btn-primary {
    background-color: #3498db !important;
    border-color: #3498db !important;
}

.btn-warning {
    background-color: #f1c40f !important;
    border-color: #f1c40f !important;
    color: #fff !important;
}

/* Form group spacing */
.form-group {
    margin-bottom: 15px !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 10px !important;
    }
    
    .attendance-details {
        padding: 15px !important;
    }
}

.modal-lg {
    max-width: 1500px;
}

.modal-header {
    padding: 1rem;
}

.badge {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.card {
    border-radius: 10px;
}

.card-body {
    padding: 1rem;
}

.table td {
    vertical-align: middle;
}

.form-control-sm {
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

<div class="chamcong-content">
<link rel="stylesheet" href="assets/css/stylecolor.css">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-12 col-lg-auto">
            <div class="page-heading">
                <h3 class="mb-0">Quản lý chấm công</h3>
            </div>
        </div>
    </div>

    <div class="filter-card">
        <!-- Form lọc -->
        <form method="GET" class="mb-0">
            <input type="hidden" name="act" value="chamcong_quanly">
            <div class="row align-items-end">
            <div class="col-md-3">
                    <label>Chọn rạp</label>
                    <?php
                    $user_role = $_SESSION['user1']['vai_tro'];     // Thay thế theo logic của bạn
                    $current_rap_id = $_SESSION['user1']['rap_id']; // ID rạp của nhân viên nếu là nhân viên
                    $is_employee = ($user_role === 3);            // Kiểm tra vai trò có phải nhân viên
                    ?>
                    <select name="rap" class="form-control" <?= $is_employee ? 'disabled' : 'required' ?>>
                        <option value="">Tất cả rạp</option>
                        <?php foreach ($dsRap as $rap):
                            $selected = ($rap['id'] == $current_rap_id) ? 'selected' : '';
                        ?>
                            <option value="<?= $rap['id'] ?>" <?= $selected ?>><?= $rap['tenrap'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php if ($is_employee): ?>
                        <input type="hidden" name="rap" value="<?= $current_rap_id ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <div class="date-filter">
                        <div>
                            <label>Tháng</label>
                            <select name="thang" class="form-control">
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $thang ? 'selected' : '' ?>>
                                        Tháng <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label>Năm</label>
                            <select name="nam" class="form-control">
                                <?php for($i = date('Y'); $i >= date('Y')-2; $i--): ?>
                                    <option value="<?= $i ?>" <?= $i == $nam ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter mr-2"></i>Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bảng chấm công ngày hôm nay -->
    <div class="filter-card">
        <h4 class="mb-4">Chấm công quản lý ngày <?= date('d/m/Y') ?></h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Quản lý</th>
                        <th>Rạp</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($dsQuanLyHomNay as $ql): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                <?= $ql['ten_quanly'] ?>
                            </div>
                        </td>
                        <td>
                            <i class="fas fa-building mr-2"></i>
                            <?= $ql['tenrap'] ?>
                        </td>
                        <td>
                            <span class="badge badge-<?= getTrangThaiBadgeClass($ql['trang_thai_cham_cong']) ?>">
                                <?= $ql['trang_thai_cham_cong'] ?>
                            </span>
                        </td>
                        <td>
                            <form action="index.php?act=xu_ly_chamcong" method="POST" class="d-inline">
                                <input type="hidden" name="id_lichlamviec" value="<?= $ql['id'] ?>">
                                <input type="hidden" name="redirect" value="chamcong_quanly">
                                <div class="d-flex align-items-center">
                                    <select name="trang_thai" class="form-control mr-2" style="width: auto">
                                        <option value="đúng giờ" <?= $ql['trang_thai_cham_cong'] == 'đúng giờ' ? 'selected' : '' ?>>
                                            Đúng giờ
                                        </option>
                                        <option value="đi trễ" <?= $ql['trang_thai_cham_cong'] == 'đi trễ' ? 'selected' : '' ?>>
                                            Đi trễ
                                        </option>
                                        <option value="vắng" <?= $ql['trang_thai_cham_cong'] == 'vắng' ? 'selected' : '' ?>>
                                            Vắng
                                        </option>
                                    </select>
                                    <button type="submit" class="btn btn-sm <?= $ql['trang_thai_cham_cong'] == 'chưa chấm công' ? 'btn-primary' : 'btn-warning' ?>">
                                        <i class="fas fa-<?= $ql['trang_thai_cham_cong'] == 'chưa chấm công' ? 'check' : 'edit' ?> mr-1"></i>
                                        <?= $ql['trang_thai_cham_cong'] == 'chưa chấm công' ? 'Chấm công' : 'Cập nhật' ?>
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

    <!-- Thống kê theo tháng -->
    <div class="stats-card">
        <h4>
            <i class="fas fa-chart-bar mr-2"></i>
            Thống kê tháng <?= $thang ?>/<?= $nam ?>
        </h4>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Quản lý</th>
                        <th class="text">Tổng ngày công</th>
                        <th class="text">Đúng giờ</th>
                        <th class="text">Đi trễ</th>
                        <th class="text">Vắng</th>
                        <th class="text">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($thongKeThang as $tk): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-tie mr-2"></i>
                                <?= $tk['ten_quanly'] ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="stats-number"><?= $tk['tong_ngay'] ?></span>
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
                                    class="btn btn-sm  " 
                                    data-toggle="modal" 
                                    data-target="#modalChiTiet<?= $tk['id_taikhoan'] ?>">
                                <i class="fas fa-info-circle mr-2"></i>Chi tiết
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Thêm modal chi tiết giống như của nhân viên -->
<?php foreach($thongKeThang as $tk): ?>
    <!-- Copy modal từ file gốc và thay đổi các biến cho phù hợp -->
<?php endforeach; ?>

<!-- Thêm scripts ở cuối file -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Xử lý modal
    $('.modal').on('show.bs.modal', function () {
        $('body').addClass('modal-open');
        $(this).show();
    }).on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $(this).hide();
    });

    // Đảm bảo form trong modal hoạt động
    $('.modal form').on('submit', function(e) {
        e.stopPropagation();
    });

    // Đảm bảo select và button trong modal hoạt động
    $('.modal select, .modal button').on('click', function(e) {
        e.stopPropagation();
    });

    // Cập nhật form action khi thay đổi giờ vào/ra
    $('.time-input').on('change', function() {
        const id = $(this).attr('name').match(/\d+/)[0];
        const gioVao = $(`input[name="gio_vao[${id}]"]`).val();
        const gioRa = $(`input[name="gio_ra[${id}]"]`).val();
        
        if(gioVao && gioRa) {
            // Tự động cập nhật trạng thái dựa trên giờ vào
            const thoiGianVao = new Date(`2000-01-01 ${gioVao}`);
            const gioMuon = new Date(`2000-01-01 08:15`); // 8:15 là thời gian muộn
            
            const select = $(`select[name="trang_thai"]`);
            if(thoiGianVao > gioMuon) {
                select.val('đi trễ');
            } else {
                select.val('đúng giờ');
            }
        }
    });
});
</script>

<!-- Modal chi tiết -->
<?php foreach($thongKeThang as $tk): ?>
<div class="modal fade" id="modalChiTiet<?= $tk['id_taikhoan'] ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-clock mr-2"></i>
                    Chi tiết chấm công - <?= $tk['ten_quanly'] ?>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form chọn tháng -->
                <form method="GET" class="mb-3">
                    <input type="hidden" name="act" value="chamcong_quanly">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <label class="mb-0 mr-2">Chọn tháng:</label>
                        </div>
                        <div class="col-md-6">
                            <input type="month" name="thang" class="form-control" 
                                   value="<?= $nam ?>-<?= sprintf("%02d", $thang) ?>"
                                   onchange="this.form.submit()">
                        </div>
                    </div>
                </form>

                <!-- Bảng chi tiết chấm công -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Ngày</th>
                                <th>Rạp</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tk['chi_tiet'] as $ct): ?>
                            <tr>
                                <td>
                                    <i class="fas fa-calendar-day mr-2 text-primary"></i>
                                    <?= date('d/m/Y', strtotime($ct['ngay_lam_viec'])) ?>
                                </td>
                                <td>
                                    <i class="fas fa-building mr-2 text-info"></i>
                                    <?= $ct['tenrap'] ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= getTrangThaiBadgeClass($ct['trang_thai_cham_cong']) ?>">
                                        <?= $ct['trang_thai_cham_cong'] ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="index.php?act=xu_ly_chamcong" method="POST" class="d-flex">
                                        <input type="hidden" name="id_lichlamviec" value="<?= $ct['id'] ?>">
                                        <input type="hidden" name="redirect" value="chamcong_quanly">
                                        <select name="trang_thai" class="form-control form-control-sm mr-2">
                                            <option value="đúng giờ" <?= $ct['trang_thai_cham_cong'] == 'đúng giờ' ? 'selected' : '' ?>>
                                                Đúng giờ
                                            </option>
                                            <option value="đi trễ" <?= $ct['trang_thai_cham_cong'] == 'đi trễ' ? 'selected' : '' ?>>
                                                Đi trễ
                                            </option>
                                            <option value="vắng" <?= $ct['trang_thai_cham_cong'] == 'vắng' ? 'selected' : '' ?>>
                                                Vắng
                                            </option>
                                        </select>
                                        <button type="submit" 
                                                class="btn btn-sm <?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'btn-primary' : 'btn-warning' ?>">
                                            <i class="fas fa-<?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'check' : 'edit' ?> mr-1"></i>
                                            <?= $ct['trang_thai_cham_cong'] == 'chưa chấm công' ? 'Chấm công' : 'Cập nhật' ?>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Thống kê tháng -->
                <div class="mt-4">
                    <h6 class="font-weight-bold">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Thống kê tháng <?= $thang ?>/<?= $nam ?>
                    </h6>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Tổng ngày</h6>
                                    <h4 class="mb-0"><?= $tk['tong_ngay'] ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Đúng giờ</h6>
                                    <h4 class="mb-0"><?= $tk['dung_gio'] ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Đi trễ</h6>
                                    <h4 class="mb-0"><?= $tk['di_tre'] ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Vắng</h6>
                                    <h4 class="mb-0"><?= $tk['vang'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


