<?php
include "./view/home/sideheader.php";
$rap_list = getAllRap();

// Lấy thông tin nhân viên từ URL
$ten_nhanvien = isset($_GET['ten']) ? $_GET['ten'] : '';
$id_rap = isset($_GET['rap']) ? $_GET['rap'] : '';

// Load lịch làm việc của nhân viên
$lichlamviec = loadLichNhanVien($ten_nhanvien, $id_rap);
$first_record = reset($lichlamviec);

// Lấy thông tin tuần đầu tiên
$first_week = reset($lichlamviec);
if($first_week) {
    $ngay_bat_dau = $first_week['ngay_lam_viec'];
    $cong_viec = $first_week['ten_cong_viec'];
}

$tomorrow = date('Y-m-d', strtotime('+1 day'));
?>

<!-- Giữ nguyên phần CSS -->

/* Copy toàn bộ CSS từ file them_nhanvien.php */

<style>
.main-content-wrap {
    margin-left: 250px !important;
    padding-top: 85px !important;
    min-height: 100vh;
    background: #F4F5F9;
    position: relative;
    z-index: 1;
}

.container-fluid {
    width: 100%;
    padding-right: 30px;
    padding-left: 30px;
    margin-right: auto;
    margin-left: auto;
}

.card-schedule {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    padding: 25px;
    margin-bottom: 30px;
}

.schedule-table {
    width: 100%;
    margin: 20px 0;
    border-radius: 8px;
    overflow: hidden;
    border-collapse: separate;
    border-spacing: 0;
}

.schedule-table th {
    padding: 15px 10px;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
    background: #3f87f5;
    color: white;
    border: 1px solid #2970d6;
}

.schedule-table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #e0e0e0;
    background: #fff;
}

.schedule-checkbox {
    position: relative;
    display: inline-block;
}

.schedule-checkbox input[type="checkbox"] {
    display: none;
}

.schedule-checkbox label {
    display: inline-block;
    width: 30px;
    height: 30px;
    border-radius: 4px;
    background: #f0f0f0;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
}

.schedule-checkbox input[type="checkbox"]:checked + label {
    background: #3f87f5;
}

.schedule-checkbox input[type="checkbox"]:checked + label:after {
    content: '✓';
    color: white;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.button {
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
}

.button i {
    margin-right: 5px;
}

.button-danger {
    color: #dc3545;
    border-color: #dc3545;
}

.button-danger:hover {
    background: #dc3545;
    color: white;
}

.d-flex {
    display: flex !important;
}

.justify-content-between {
    justify-content: space-between !important;
}

.align-items-center {
    align-items: center !important;
}

.mr-1 {
    margin-right: 4px;
}

.schedule-checkbox label.disabled {
    background: #e9ecef;
    cursor: not-allowed;
    opacity: 0.5;
}

.day-header {
    min-width: 120px;
    line-height: 1.4;
}

/* Thêm màu nền cho ngày hiện tại */
.current-day {
    background: #e3f2fd !important;
}

/* Style cho ngày nghỉ (chủ nhật) */
.sunday {
    background: #ffebee !important;
}

/* Hiệu ứng hover cho ô có thể chọn */
.schedule-checkbox label:not(.disabled):hover {
    background: #e3f2fd;
    transform: scale(1.05);
    transition: all 0.2s ease;
}

</style>

<div class="main-content-wrap">
    
    <div class="container-fluid">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Sửa lịch làm việc nhân viên</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-30">
                <form action="index.php?act=updatenhanvien" method="post">
                    <input type="hidden" name="id_taikhoan" value="<?= $first_record['id_taikhoan'] ?>">
                    <input type="hidden" name="ten" value="<?= $first_record['ten_nguoi_lam'] ?>">
                    <div class="card-schedule">
                        <div class="row">
                            <!-- Thông tin nhân viên -->
                            <div class="col-md-6 mb-20">
                                <label class="form-label">Tên nhân viên</label>
                                <input type="text" class="form-control" name="ten_nhanvien" 
                                       value="<?= $first_record['ten_nguoi_lam'] ?>" required>
                            </div>
                            
                            <!-- Chọn rạp -->
                            <div class="col-md-6 mb-20">
                                <label class="form-label">Chọn rạp</label>
                                <select class="form-control" name="id_rap" required>
                                    <?php foreach($rap_list as $rap): ?>
                                        <option value="<?= $rap['id'] ?>" 
                                            <?= ($rap['id'] == $first_record['id_rap']) ? 'selected' : '' ?>>
                                            <?= $rap['tenrap'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Ngày bắt đầu -->
                            <div class="col-md-4 mb-20">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="date" class="form-control" name="ngay_bat_dau" 
                                       value="<?= $first_record['ngay_lam_viec'] ?>" required>
                            </div>

                            <div class="col-md-4 mb-20">
                                <label class="form-label">Số tuần</label>
                                <input type="number" class="form-control" name="so_tuan" 
                                       min="1" value="1" required>
                            </div>
                            
                            <!-- Công việc -->
                            <div class="col-md-4 mb-20">
                                <label class="form-label">Công việc</label>
                                <select class="form-control" name="ten_cong_viec" required>
                                    <option value="Nhân viên bán vé" <?= ($first_record['ten_cong_viec'] == 'Nhân viên bán vé') ? 'selected' : '' ?>>Nhân viên bán vé</option>
                                    <option value="Nhân viên phòng chiếu" <?= ($first_record['ten_cong_viec'] == 'Nhân viên phòng chiếu') ? 'selected' : '' ?>>Nhân viên phòng chiếu</option>
                                    <option value="Nhân viên vệ sinh" <?= ($first_record['ten_cong_viec'] == 'Nhân viên vệ sinh') ? 'selected' : '' ?>>Nhân viên vệ sinh</option>
                                    <option value="Nhân viên bảo vệ" <?= ($first_record['ten_cong_viec'] == 'Nhân viên bảo vệ') ? 'selected' : '' ?>>Nhân viên bảo vệ</option>
                                    <option value="Nhân viên phục vụ đồ ăn và thức uống" <?= ($first_record['ten_cong_viec'] == 'Nhân viên phục vụ đồ ăn và thức uống') ? 'selected' : '' ?>>Nhân viên phục vụ đồ ăn và thức uống</option>
                                    <option value="Kỹ thuật viên" <?= ($first_record['ten_cong_viec'] == 'Kỹ thuật viên') ? 'selected' : '' ?>>Kỹ thuật viên</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng chọn ca làm việc -->
                    <div class="card-schedule">
                        <h4 class="mb-15">Chọn ca làm việc</h4>
                        <div class="table-responsive">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Ca làm</th>
                                        <?php 
                                        // Lấy ngày bắt đầu từ form hoặc dữ liệu
                                        $start_date = isset($first_record['ngay_lam_viec']) ? $first_record['ngay_lam_viec'] : date('Y-m-d', strtotime('+1 day'));
                                        
                                        // Hiển thị 7 ngày từ ngày bắt đầu
                                        for($i = 0; $i < 7; $i++): 
                                            $current_date = date('Y-m-d', strtotime($start_date . " +$i days"));
                                            $thu = date('w', strtotime($current_date));
                                            $thu_text = $thu == 0 ? "Chủ nhật" : "Thứ " . ($thu + 1);
                                        ?>
                                            <th class="day-header">
                                                <?= $thu_text ?><br>
                                                <?= date('d/m/Y', strtotime($current_date)) ?>
                                            </th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $ca_lam = array(
                                        1 => "Ca 1 (8:00-12:00)",
                                        2 => "Ca 2 (12:00-16:00)",
                                        3 => "Ca 3 (16:00-20:00)",
                                        4 => "Ca 4 (20:00-24:00)"
                                    );
                                    
                                    foreach($ca_lam as $ca => $ten_ca): ?>
                                    <tr>
                                        <td><strong><?= $ten_ca ?></strong></td>
                                        <?php 
                                        // Hiển thị checkbox cho từng ngày
                                        for($thu = 0; $thu < 7; $thu++): 
                                            $ngay = date('Y-m-d', strtotime($start_date . " +$thu days"));
                                            
                                            // Kiểm tra xem ca này có được chọn trong lịch cũ không
                                            $checked = false;
                                            foreach($lichlamviec as $lich) {
                                                if($lich['ca_lam_viec'] == $ten_ca && 
                                                   $lich['ngay_lam_viec'] == $ngay) {
                                                    $checked = true;
                                                    break;
                                                }
                                            }
                                            
                                            // Kiểm tra ngày có phải là quá khứ không
                                            $is_past = strtotime($ngay) < strtotime(date('Y-m-d'));
                                        ?>
                                        <td>
                                            <div class="schedule-checkbox">
                                                <input type="checkbox" 
                                                       id="ca_<?= $ca ?>_<?= $thu ?>" 
                                                       name="lich[<?= $thu ?>][<?= $ca ?>]" 
                                                       value="1"
                                                       data-day="<?= $thu ?>"
                                                       data-date="<?= $ngay ?>"
                                                       <?= $checked ? 'checked' : '' ?>
                                                       <?= $is_past ? 'disabled' : '' ?>>
                                                <label for="ca_<?= $ca ?>_<?= $thu ?>" 
                                                       class="<?= $is_past ? 'disabled' : '' ?>">
                                                </label>
                                            </div>
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Nút submit -->
                        <div class="text-right mt-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="index.php?act=lichlamviec" class="button button-outline button-danger">
                                    <i class="zmdi zmdi-arrow-left mr-1"></i>Quay về danh sách
                                </a>
                                
                                <button type="submit" name="capnhat" class="button button-outline button-primary">
                                    <i class="zmdi zmdi-check mr-1"></i>Cập nhật lịch làm việc
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="ngay_bat_dau"]');
    const tomorrow = '<?= $tomorrow ?>';
    
    // Lưu trữ dữ liệu lịch làm việc từ PHP sang JavaScript
    const lichLamViec = <?= json_encode($lichlamviec) ?>;
    
    function updateSchedule() {
        const selectedDate = new Date(dateInput.value);
        const dayHeaders = document.querySelectorAll('.day-header');
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        
        // Cập nhật header
        dayHeaders.forEach((header, index) => {
            const currentDate = new Date(selectedDate);
            currentDate.setDate(currentDate.getDate() + index);
            
            const thu = currentDate.getDay();
            const thu_text = thu === 0 ? "Chủ nhật" : "Thứ " + (thu + 1);
            const formattedDate = currentDate.toLocaleDateString('vi-VN');
            
            header.innerHTML = `${thu_text}<br>${formattedDate}`;
            
            if(thu === 0) {
                header.classList.add('sunday');
            } else {
                header.classList.remove('sunday');
            }
        });
        
        // Cập nhật checkbox
        checkboxes.forEach(checkbox => {
            const dayIndex = parseInt(checkbox.getAttribute('data-day'));
            const caMatch = checkbox.id.match(/ca_(\d+)/);
            const caNumber = caMatch ? parseInt(caMatch[1]) : null;
            
            const currentDate = new Date(selectedDate);
            currentDate.setDate(currentDate.getDate() + dayIndex);
            const checkDate = currentDate.toISOString().split('T')[0];
            
            // Cập nhật data-date
            checkbox.setAttribute('data-date', checkDate);
            
            // Reset trạng thái
            checkbox.checked = false;
            
            // Kiểm tra xem có lịch làm việc cho ngày và ca này không
            const caText = `Ca ${caNumber} (${getCaTime(caNumber)})`;
            const hasShift = lichLamViec.some(lich => 
                lich.ngay_lam_viec === checkDate && 
                lich.ca_lam_viec === caText
            );
            
            // Cập nhật trạng thái checkbox
            if(hasShift) {
                checkbox.checked = true;
            }
            
            // Xử lý disable cho ngày quá khứ
            if(checkDate < tomorrow) {
                checkbox.disabled = true;
                checkbox.checked = false;
                checkbox.closest('td').style.opacity = '0.5';
                checkbox.nextElementSibling.classList.add('disabled');
            } else {
                checkbox.disabled = false;
                checkbox.closest('td').style.opacity = '1';
                checkbox.nextElementSibling.classList.remove('disabled');
            }
        });
    }

    // Hàm helper để lấy giờ làm việc theo ca
    function getCaTime(caNumber) {
        switch(caNumber) {
            case 1: return "8:00-12:00";
            case 2: return "12:00-16:00";
            case 3: return "16:00-20:00";
            case 4: return "20:00-24:00";
            default: return "";
        }
    }

    // Kiểm tra ngày khi thay đổi
    dateInput.addEventListener('change', function() {
        if(this.value < tomorrow) {
            alert('Chỉ được phép sửa lịch từ ngày mai!');
            this.value = tomorrow;
        }
        updateSchedule();
    });

    // Khởi tạo khi load trang
    if(dateInput.value < tomorrow) {
        dateInput.value = tomorrow;
    }
    updateSchedule();
});
</script>