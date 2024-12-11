<?php
include "./view/home/sideheader.php";

if(isset($_POST['len'])) {
    $ten_km = $_POST['ten_km'];
    $gia_tri = $_POST['gia_tri'];
    $ngay_ket_thuc = $_POST['ngay_ket_thuc'];
    $mota = $_POST['mota'];
    
    // Lấy ngày mai
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    
    // Kiểm tra ngày kết thúc phải lớn hơn ngày mai
    if(strtotime($ngay_ket_thuc) <= strtotime($tomorrow)) {
        $error = "Ngày kết thúc phải lớn hơn ngày mai!";
    } else {
        // Thêm vào CSDL nếu hợp lệ
        $sql = "INSERT INTO khuyenmai(ten_km, gia_tri, ngay_ket_thuc, mota) VALUES (?, ?, ?, ?)";
        pdo_execute($sql, $ten_km, $gia_tri, $ngay_ket_thuc, $mota);
        $suatc = "Thêm thành công!";
    }
}
?>
<!-- Content Body Start -->
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Thêm khuyến mãi</h3>
            </div>
        </div>
    </div>

    <?php if(isset($suatc) && ($suatc) != ""): ?>
        <p style="color: red; text-align: center;"><?= $suatc ?></p>
    <?php endif; ?>

    <form action="index.php?act=themkhuyenmai" method="POST" id="promotionForm">
        <div class="row">
            <div class="col-lg-6 col-12 mb-30">
                <span class="title">Tên khuyến mãi <span class="text-danger">*</span></span>
                <input class="form-control" type="text" name="ten_km" required>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12 mb-30">
                <span class="title">Giá trị (1-100) <span class="text-danger">*</span></span>
                <input class="form-control" type="number" name="gia_tri" min="1" max="100" required>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12 mb-30">
                <span class="title">Ngày kết thúc <span class="text-danger">*</span></span>
                <input class="form-control" type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" required>
            </div>
        </div>

    <div class="row">
        <div class="col-lg-6 col-12 mb-30">
            <span class="title">Mô tả</span>
            <textarea class="form-control" name="mota" rows="4"></textarea>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-6 col-12 mb-30">
                <button class="button button-outline button-primary mb-10 ml-10 mr-0" 
                        type="submit" name="len">Thêm mới</button>
            </div>
        </div>
    </form>

    <?php if(isset($error) && $error != ""): ?>
        <p style="color: red; text-align: center;"><?= $error ?></p>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy ngày mai
    var today = new Date();
    var tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    // Format date to YYYY-MM-DD
    var tomorrowFormatted = tomorrow.toISOString().split('T')[0];
    
    // Set min date cho input
    var dateInput = document.getElementById('ngay_ket_thuc');
    dateInput.min = tomorrowFormatted;
    
    // Validate form trước khi submit
    document.getElementById('promotionForm').addEventListener('submit', function(e) {
        var selectedDate = new Date(dateInput.value);
        // So sánh với ngày mai (không tính giờ phút giây)
        if(selectedDate.setHours(0,0,0,0) <= tomorrow.setHours(0,0,0,0)) {
            e.preventDefault();
            alert('Ngày kết thúc phải lớn hơn ngày mai!');
        }
    });
});
</script>