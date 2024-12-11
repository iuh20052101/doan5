<?php include "./view/home/sideheader.php"; ?>

<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <?php if ($_SESSION['user1']['vai_tro'] == 2 || $_SESSION['user1']['vai_tro'] == 1) { ?>
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading">
                    <h3><i class="zmdi zmdi-home mr-2"></i>Trang Quản Lý</h3>
                </div>
            </div>

            <!-- Thông tin nhanh -->
            <div class="col-12 mb-30">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h4>Xin chào, <?= $_SESSION['user1']['name'] ?>!</h4>
                        <p class="current-time">
                            <i class="zmdi zmdi-time mr-2"></i>
                            <span id="real-time-clock"></span>
                        </p>
                        <p class="current-date">
                            <i class="zmdi zmdi-calendar mr-2"></i>
                            <?= date('d/m/Y') ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Nội quy -->
            <div class="col-12 mb-30">
                <div class="box">
                    <div class="box-head">
                        <h4>
                            <i class="zmdi zmdi-info-outline mr-2"></i>
                            Nội quy & Quy định Quản lý rạp
                        </h4>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="rule-card">
                                    <div class="rule-icon">
                                        <i class="zmdi zmdi-time-countdown"></i>
                                    </div>
                                    <h5>Quản lý thời gian</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="zmdi zmdi-check mr-2"></i>Đúng giờ làm việc</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>Chấm công chính xác</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>Lịch chiếu đúng giờ</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rule-card">
                                    <div class="rule-icon">
                                        <i class="zmdi zmdi-accounts"></i>
                                    </div>
                                    <h5>Quản lý nhân sự</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="zmdi zmdi-check mr-2"></i>Giám sát nhân viên</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>Phân công công việc</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>Đào tạo nhân viên mới</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="rule-card">
                                    <div class="rule-icon">
                                        <i class="zmdi zmdi-settings"></i>
                                    </div>
                                    <h5>Vận hành & An toàn</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="zmdi zmdi-check mr-2"></i>Kiểm tra thiết bị</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>Đảm bảo vệ sinh</li>
                                        <li><i class="zmdi zmdi-check mr-2"></i>An toàn PCCC</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thống kê -->
            <div class="row">
                <!-- Giữ nguyên các thẻ thống kê nhưng thêm animation và icons -->
            </div>

        <?php } else { ?>
            <h1>Chào mừng <?= $_SESSION['user1']['name'] ?> đến với trang làm việc của TIAMS</h1>
        <?php } ?>
    </div>
</div>

<style>
/* Welcome Card */
.welcome-card {
    background: linear-gradient(45deg, #2196F3, #1976D2);
    border-radius: 15px;
    padding: 25px;
    color: white;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(33, 150, 243, 0.3);
}

.welcome-card h4 {
    font-size: 24px;
    margin-bottom: 15px;
}

.current-time, .current-date {
    font-size: 16px;
    margin: 5px 0;
    opacity: 0.9;
}

/* Rule Cards */
.rule-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.rule-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.rule-icon {
    font-size: 40px;
    color: #1976D2;
    margin-bottom: 20px;
}

.rule-card h5 {
    color: #1a237e;
    font-weight: 600;
    margin-bottom: 15px;
}

.rule-card ul li {
    color: #555;
    margin-bottom: 10px;
    text-align: left;
}

.zmdi-check {
    color: #4CAF50;
}

/* Box styling */
.box {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.box-head {
    background: #1976D2;
    color: white;
    padding: 20px 25px;
}

.box-head h4 {
    margin: 0;
    font-weight: 600;
}

.box-body {
    padding: 25px;
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.rule-card {
    animation: fadeIn 0.5s ease-out forwards;
}

.rule-card:nth-child(2) {
    animation-delay: 0.2s;
}

.rule-card:nth-child(3) {
    animation-delay: 0.4s;
}
</style>

<script>
function updateClock() {
    const now = new Date();
    const time = now.toLocaleTimeString('vi-VN');
    document.getElementById('real-time-clock').textContent = time;
    setTimeout(updateClock, 1000);
}
updateClock();
</script>
