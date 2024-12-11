<?php
include "./view/home/sideheader.php";

// Lấy danh sách quản lý chưa được phân công
$sql_nhanvien = "SELECT id, name FROM taikhoan WHERE vai_tro = 1";
$nhanvien_list = pdo_query($sql_nhanvien);

// Lấy danh sách rạp
$sql_rap = "SELECT id, tenrap FROM rap";
$rap_list = pdo_query($sql_rap);
?>

<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Thêm lịch quản lý</h3>
            </div>
        </div>
    </div>

    <?php if (isset($suatc) && ($suatc) != "") {
        echo '<p style="color: green; text-align: center;">' . $suatc . '</p>';
    } ?>

    <?php if (isset($error) && ($error) != "") {
        echo '<p style="color: red; text-align: center;">' . $error . '</p>';
    } ?>

    <form action="index.php?act=themvitriquanly" method="post">
        <div class="add-edit-product-wrap col-12">
            <div class="add-edit-product-form">
                <h4 class="title">Thông tin phân công</h4>

                <div class="row">
                    <!-- Chọn quản lý -->
                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Chọn quản lý</label>
                        <select class="form-control" name="id_taikhoan" required>
                            <option value="">-- Chọn quản lý --</option>
                            <?php foreach ($nhanvien_list as $nv): ?>
                                <option value="<?= $nv['id'] ?>"><?= $nv['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Chọn rạp -->
                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Chọn rạp</label>
                        <?php
                        $user_role = $_SESSION['user1']['vai_tro'];     // Thay thế theo logic của bạn
                        $current_rap_id = $_SESSION['user1']['rap_id']; // ID rạp của nhân viên nếu là nhân viên
                        $is_employee = ($user_role === 3);            // Kiểm tra vai trò có phải nhân viên
                        ?>
                        <select name="id_rap" class="form-control" <?= $is_employee ? 'disabled' : 'required' ?>>
                            <option value="">Chọn rạp</option>
                            <?php foreach ($rap_list as $rap):
                                $selected = ($rap['id'] == $current_rap_id) ? 'selected' : '';
                            ?>
                                <option value="<?= $rap['id'] ?>" <?= $selected ?>><?= $rap['tenrap'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($is_employee): ?>
                            <input type="hidden" name="id_rap" value="<?= $current_rap_id ?>">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <!-- Chọn tháng -->
                    <div class="col-lg-6 col-12 mb-30">

                        <label>Chọn tháng làm việc:</label>
                        <input type="month" name="ngay_lam_viec" class="form-control"
                            value="<?= isset($thang_lam) ? $thang_lam : date('Y-m') ?>"
                            min="<?= date('Y-m') ?>">
                    </div>
                </div>

                <!-- Chọn công việc -->
                <div class="col-lg-6 col-12 mb-30">
                    <label class="form-label">Công việc</label>
                    <select class="form-control" name="ten_cong_viec" required>
                        <option value="">-- Chọn công việc --</option>
                        <option value="Quản lý lịch chiếu">Quản lý lịch chiếu</option>
                        <option value="Quản lý phòng chiếu">Quản lý phòng chiếu</option>
                        <option value="Quản lý khuyến mãi">Quản lý khuyến mãi</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="d-flex flex-wrap justify-content-end col mbn-10">
                    <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                        type="submit" name="len">Thêm</button>
                </div>
            </div>
        </div>
</div>
</form>
</div>

<style>
    /* Reset và override styles */
    .content-body {
        padding: 30px !important;
        margin-left: 280px !important;
        background: #f5f6fa !important;
        min-height: 100vh !important;
        width: calc(100% - 280px) !important;
    }

    /* Form container */
    .add-edit-product-wrap {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 30px;
        margin-top: 20px;
    }

    /* Page title */
    .page-heading h3 {
        color: #2c3e50;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Form section title */
    .title {
        color: #2c3e50;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        position: relative;
    }

    .title:after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 50px;
        height: 2px;
        background: #3498db;
    }

    /* Form controls */
    .form-label {
        font-weight: 500;
        margin-bottom: 10px;
        color: #34495e;
        font-size: 15px;
        display: block;
    }

    .form-control {
        height: 45px !important;
        border: 2px solid #e9ecef !important;
        border-radius: 8px !important;
        padding: 10px 15px !important;
        font-size: 14px !important;
        transition: all 0.3s ease !important;
        background: #fff !important;
    }

    .form-control:focus {
        border-color: #3498db !important;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.25) !important;
    }

    select.form-control {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath fill='%23343a40' d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3E%3C/svg%3E") !important;
        background-repeat: no-repeat !important;
        background-position: right 10px center !important;
        background-size: 20px !important;
        padding-right: 40px !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
    }

    /* Button styles */
    .button {
        height: 45px !important;
        padding: 0 30px !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 15px !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .button-primary {
        background: #3498db !important;
        color: #fff !important;
        border: none !important;
    }

    .button-primary:hover {
        background: #2980b9 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3) !important;
    }

    .button-outline-primary {
        background: transparent !important;
        border: 2px solid #3498db !important;
        color: #3498db !important;
    }

    .button-outline-primary:hover {
        background: #3498db !important;
        color: #fff !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3) !important;
    }

    /* Alert messages */
    .alert {
        padding: 15px 20px !important;
        border-radius: 8px !important;
        margin-bottom: 20px !important;
        font-size: 14px !important;
    }

    .alert-success {
        background: #d4edda !important;
        color: #155724 !important;
        border: 1px solid #c3e6cb !important;
    }

    .alert-danger {
        background: #f8d7da !important;
        color: #721c24 !important;
        border: 1px solid #f5c6cb !important;
    }

    /* Spacing utilities */
    .mb-30 {
        margin-bottom: 30px !important;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .content-body {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }

    @media (max-width: 768px) {
        .add-edit-product-wrap {
            padding: 20px !important;
        }

        .page-heading h3 {
            font-size: 24px !important;
        }
    }
</style>