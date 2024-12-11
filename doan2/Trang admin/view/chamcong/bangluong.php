<?php include "./view/home/sideheader.php"; ?>

<style>
/* Reset và override styles */
.content-body {
    padding: 30px !important;
    margin-left: 280px !important; /* Điều chỉnh theo width của sidebar */
    background: #f5f6fa !important;
    min-height: 100vh !important;
}

/* Custom styles cho trang bảng lương */
.salary-box {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    margin-bottom: 25px;
    border: 1px solid rgba(0,0,0,0.05);
}

.salary-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.salary-box .box-body {
    padding: 30px;
}

.salary-box h4 {
    color: #2c3e50;
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: 600;
}

.salary-box p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
}

.salary-box .button {
    padding: 12px 30px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s;
    text-transform: none;
    font-size: 15px;
}

.salary-box .button:hover {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.rules-box {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-top: 20px;
    border: 1px solid rgba(0,0,0,0.05);
}

.rules-box .box-head {
    background: #f8f9fa;
    padding: 25px 30px;
    border-radius: 15px 15px 0 0;
    border-bottom: 2px solid #eee;
}

.rules-box .box-head h3 {
    color: #2c3e50;
    margin: 0;
    font-size: 26px;
    font-weight: 600;
}

.rules-box .box-body {
    padding: 35px;
}

.rules-box h4 {
    color: #2c3e50;
    font-size: 22px;
    margin-bottom: 25px;
    padding-bottom: 12px;
    border-bottom: 3px solid #3498db;
    display: inline-block;
}

.rules-box ul {
    margin-bottom: 25px;
    padding-left: 0;
}

.rules-box ul li {
    margin-bottom: 18px;
    color: #34495e;
    line-height: 1.7;
    font-size: 15px;
}

.rules-box ul li strong {
    color: #2c3e50;
    font-size: 17px;
    display: block;
    margin-bottom: 8px;
}

.rules-box ul li ul {
    margin: 12px 0 12px 25px;
}

.rules-box ul li ul li {
    margin-bottom: 10px;
    color: #576574;
    position: relative;
    padding-left: 20px;
}

.rules-box ul li ul li:before {
    content: "•";
    color: #3498db;
    position: absolute;
    left: 0;
    font-size: 18px;
}

.page-heading h3 {
    color: #2c3e50;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 30px;
}

.salary-amount {
    color: #e74c3c;
    font-weight: 600;
    font-size: 16px;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .content-body {
        margin-left: 0 !important;
    }
}

@media (max-width: 768px) {
    .content-body {
        padding: 20px !important;
    }
    
    .salary-box {
        margin-bottom: 20px;
    }
    
    .rules-box .box-body {
        padding: 20px;
    }
    
    .rules-box h4 {
        font-size: 20px;
    }
    
    .page-heading h3 {
        font-size: 26px;
    }
}
</style>

<div class="content-body">
    <!-- Tiêu đề trang -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Bảng Lương</h3>
            </div>
        </div>
    </div>

    <!-- Các nút điều hướng -->
    <div class="row mb-20">
        <div class="col-md-6">
            <div class="box">
                <div class="box-body text-center">
                    <h4>Bảng Lương Quản Lý</h4>
                    <p class="mb-20">Xem bảng lương và chi tiết chấm công của quản lý</p>
                    <a href="index.php?act=bangluong_quanly" class="button button-primary">
                        <i class="fa fa-eye"></i> Xem Bảng Lương Quản Lý
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-body text-center">
                    <h4>Bảng Lương Nhân Viên</h4>
                    <p class="mb-20">Xem bảng lương và chi tiết chấm công của nhân viên</p>
                    <a href="index.php?act=bangluong_nhanvien" class="button button-primary">
                        <i class="fa fa-eye"></i> Xem Bảng Lương Nhân Viên
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quy định lương -->
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Quy Định Lương</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <!-- Quy định lương quản lý -->
                        <div class="col-md-6">
                            <h4>Quản Lý:</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>1. Lương cơ bản:</strong> 
                                    <ul>
                                        <li>Lương theo ngày: <?= number_format(LUONG_NGAY_QUANLY) ?>đ/ngày</li>
                                    </ul>
                                </li>
                                <li class="mb-2">
                                    <strong>2. Thưởng chuyên cần:</strong>
                                    <ul>
                                        <li>Điều kiện: Làm việc ≥ 20 ngày/tháng</li>
                                        <li>Mức thưởng: <?= number_format(THUONG_CHUYEN_CAN_QUANLY) ?>đ/tháng</li>
                                    </ul>
                                </li>
                                <li class="mb-2">
                                    <strong>3. Tiền phạt:</strong>
                                    <ul>
                                        <li>Vắng không phép: <?= number_format(PHAT_VANG_QUANLY) ?>đ/ngày</li>
                                        <li>Đi trễ: <?= number_format(PHAT_TRE_QUANLY) ?>đ/lần</li>
                                    </ul>
                                </li>
                                <li>
                                    <strong>4. Tổng lương = Lương cơ bản + Thưởng chuyên cần - Tiền phạt</strong>
                                </li>
                            </ul>
                        </div>

                        <!-- Quy định lương nhân viên -->
                        <div class="col-md-6">
                            <h4>Nhân Viên:</h4>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>1. Lương theo ca làm việc:</strong>
                                    <ul>
                                        <?php foreach(LUONG_THEO_CONGVIEC as $congviec => $mucluong): ?>
                                        <li><?= $congviec ?>: <?= number_format($mucluong) ?>đ/ca</li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="mb-2">
                                    <strong>2. Thưởng chuyên cần:</strong>
                                    <ul>
                                        <li>Điều kiện: Làm việc ≥ 80 ca/tháng</li>
                                        <li>Mức thưởng: <?= number_format(THUONG_CHUYEN_CAN_NHANVIEN) ?>đ/tháng</li>
                                    </ul>
                                </li>
                                <li class="mb-2">
                                    <strong>3. Tiền phạt:</strong>
                                    <ul>
                                        <li>Vắng không phép: <?= number_format(PHAT_VANG_NHANVIEN) ?>đ/ca</li>
                                        <li>Đi trễ: <?= number_format(PHAT_TRE_NHANVIEN) ?>đ/lần</li>
                                    </ul>
                                </li>
                                <li>
                                    <strong>4. Tổng lương = (Số ca × Lương theo công việc) + Thưởng chuyên cần - Tiền phạt</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>