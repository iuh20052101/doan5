<?php
include "./view/home/sideheader.php";

// Lấy thông tin quản lý từ URL
$ten = isset($_GET['ten']) ? $_GET['ten'] : '';
$id_rap = isset($_GET['rap']) ? $_GET['rap'] : '';

// Load lịch làm việc của quản lý
$lichlamviec = loadLichQuanLyByTenRap($ten, $id_rap);

// Kiểm tra xem có dữ liệu không
if (empty($lichlamviec)) {
    echo "<script>
            alert('Không tìm thấy thông tin lịch làm việc!');
            window.location.href='index.php?act=lichlamviec';
          </script>";
    exit;
}

$first_record = $lichlamviec[0]; // Lấy record đầu tiên

// Lấy danh sách rạp
$list_rap = getAllRap();

// Tạo mảng ngày từ ngày mai đến 30 ngày sau
$tomorrow = new DateTime('tomorrow');
$dates = array();
$existing_days = array_column($lichlamviec, 'ngay_lam_viec');

// Tạo mảng 30 ngày từ ngày mai
for($i = 0; $i < 30; $i++) {
    $date = clone $tomorrow;
    $date->modify("+$i days");
    $dates[] = $date->format('Y-m-d');
}

// Debug
error_log("Dates array: " . print_r($dates, true));
error_log("Existing days: " . print_r($existing_days, true));

// Debug
error_log("Loaded schedule data: " . print_r($lichlamviec, true));
error_log("Loaded rap data: " . print_r($list_rap, true));

if (empty($lichlamviec)) {
    echo "<div class='alert alert-danger'>Không tìm thấy dữ liệu lịch làm việc</div>";
    return;
}
?>

<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Sửa lịch quản lý</h3>
            </div>
        </div>
    </div>

    <form action="index.php?act=updatequanly&ten=<?= urlencode($ten) ?>&rap=<?= $rap_id ?>" method="POST" id="updateForm">
        <div class="add-edit-product-wrap col-12">
            <div class="add-edit-product-form">
                <input type="hidden" name="id_taikhoan" value="<?= htmlspecialchars($first_record['id_taikhoan']) ?>">
                <input type="hidden" name="id_rap" value="<?= htmlspecialchars($rap_id) ?>">
                <input type="hidden" name="ten_cong_viec" value="<?= htmlspecialchars($first_record['ten_cong_viec']) ?>">
                
                <div class="row mb-30">
                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Tên quản lý</label>
                        <input type="text" class="form-control" value="<?= $first_record['ten_nguoi_lam'] ?>" readonly>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Rạp</label>
                        <select class="form-control" name="id_rap">
                            <?php foreach($list_rap as $rap): ?>
                                <option value="<?= $rap['id'] ?>" 
                                    <?= ($rap['id'] == $rap_id) ? 'selected' : '' ?>>
                                    <?= $rap['tenrap'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-30">
                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="ngay_bat_dau" class="form-control" 
                               value="<?= $first_record['ngay_lam_viec'] ?>" required>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <label class="form-label">Công việc</label>
                        <select class="form-control" name="ten_cong_viec">
                            <?php
                            $cong_viec = array(
                                'Quản lý lịch chiếu',
                                'Quản lý phòng chiếu',
                                'Quản lý khuyến mãi'
                            );
                            foreach($cong_viec as $cv): ?>
                                <option value="<?= $cv ?>" 
                                    <?= ($cv == $first_record['ten_cong_viec']) ? 'selected' : '' ?>>
                                    <?= $cv ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Bảng lịch làm việc -->
                <div class="row mb-30">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Thứ/Ngày</th>
                                        <th>Làm việc</th>
                                    </tr>
                                </thead>
                                <tbody id="scheduleTableBody">
                                    <!-- Sẽ được điền bởi JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex flex-wrap justify-content-end col mbn-10">
                        <a href="index.php?act=lichlamviec" class="button button-outline button-danger mb-10 ml-10">
                            Quay lại
                        </a>
                        <button type="submit" name="capnhat" class="button button-outline button-primary mb-10 ml-10 mr-0">
                            Cập nhật
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[name="ngay_bat_dau"]');
    const tableBody = document.getElementById('scheduleTableBody');
    
    // Đặt múi giờ Việt Nam (UTC+7)
    const VN_TIMEZONE_OFFSET = 7 * 60 * 60 * 1000; // 7 giờ tính bằng milliseconds
    
    // Khởi tạo ngày mai theo múi giờ Việt Nam
    const tomorrow = new Date();
    tomorrow.setHours(0, 0, 0, 0); // Reset về 00:00:00
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    // Format ngày mai theo chuẩn YYYY-MM-DD
    const tomorrowFormatted = formatDateToVNTimezone(tomorrow);
    
    // Hàm format date theo múi giờ Việt Nam
    function formatDateToVNTimezone(date) {
        const vnDate = new Date(date.getTime());
        const year = vnDate.getFullYear();
        const month = String(vnDate.getMonth() + 1).padStart(2, '0');
        const day = String(vnDate.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
    
    // Lấy dữ liệu lịch làm việc từ PHP
    const lichlamviec = <?= json_encode($lichlamviec) ?>;
    console.log('Lịch làm việc:', lichlamviec);
    
    // Set ngày mặc định từ dữ liệu
    if (lichlamviec && lichlamviec.length > 0) {
        const firstDate = new Date(lichlamviec[0].ngay_lam_viec);
        dateInput.value = formatDateToVNTimezone(firstDate);
        console.log('Ngày đầu tiên từ lịch:', dateInput.value);
    } else {
        dateInput.value = tomorrowFormatted;
    }
    
    dateInput.min = tomorrowFormatted;
    
    // Thêm biến để lưu trữ tất cả các ngày đã chọn
    let selectedDays = new Set();
    
    // Khởi tạo selectedDays từ lịch làm việc hiện có
    if (lichlamviec && lichlamviec.length > 0) {
        lichlamviec.forEach(lich => {
            const workDate = new Date(lich.ngay_lam_viec);
            if (workDate > tomorrow) {
                selectedDays.add(formatDateToVNTimezone(workDate));
            }
        });
    }
    
    function updateScheduleTable(selectedDate) {
        tableBody.innerHTML = '';
        const startDate = new Date(selectedDate);
        startDate.setHours(0, 0, 0, 0);
        
        const month = startDate.getMonth();
        const year = startDate.getFullYear();
        const lastDay = new Date(year, month + 1, 0).getDate();
        
        for(let i = 1; i <= lastDay; i++) {
            const currentDate = new Date(year, month, i);
            currentDate.setHours(0, 0, 0, 0);
            
            if(currentDate < tomorrow) continue;
            
            const formattedDate = formatDateToVNTimezone(currentDate);
            
            // Kiểm tra trong selectedDays thay vì lichlamviec
            const isWorking = selectedDays.has(formattedDate);

            const dayNames = ['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
            const dayName = dayNames[currentDate.getDay()];

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${dayName} (${i}/${month + 1}/${year})</td>
                <td>
                    <input type="checkbox" 
                           name="working_days[]" 
                           value="${formattedDate}" 
                           class="form-check-input"
                           ${isWorking ? 'checked' : ''}
                           id="day_${formattedDate}"
                           onchange="handleCheckboxChange(this)">
                    <label for="day_${formattedDate}" class="form-check-label">
                        Làm việc
                    </label>
                </td>
            `;
            tableBody.appendChild(row);
        }
    }
    
    // Thêm hàm xử lý sự kiện checkbox change
    window.handleCheckboxChange = function(checkbox) {
        if (checkbox.checked) {
            selectedDays.add(checkbox.value);
        } else {
            selectedDays.delete(checkbox.value);
        }
    };
    
    // Sửa lại form submit để gửi tất cả các ngày đã chọn
    document.getElementById('updateForm').addEventListener('submit', function(e) {
        // Xóa tất cả input working_days[] hiện tại
        this.querySelectorAll('input[name="working_days[]"]').forEach(input => input.remove());
        
        // Thêm input hidden cho mỗi ngày đã chọn
        selectedDays.forEach(date => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'working_days[]';
            input.value = date;
            this.appendChild(input);
        });
    });
    
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        selectedDate.setHours(7, 0, 0, 0);
        console.log('Ngày được chọn:', selectedDate);
        
        if(selectedDate < tomorrow) {
            alert('Vui lòng chọn ngày từ ngày mai trở đi');
            this.value = tomorrowFormatted;
            updateScheduleTable(tomorrow);
        } else {
            updateScheduleTable(selectedDate);
        }
    });

    // Khởi tạo bảng với ngày từ input
    updateScheduleTable(new Date(dateInput.value));

    // Thêm event listener cho form submit
    document.getElementById('updateForm').addEventListener('submit', function(e) {
        // e.preventDefault(); // Uncomment để debug
        const checkedDays = document.querySelectorAll('input[name="working_days[]"]:checked');
        console.log('Số ngày được chọn:', checkedDays.length);
        console.log('Các ngày được chọn:', Array.from(checkedDays).map(cb => cb.value));
    });
});
</script>

<script>
document.getElementById('updateForm').addEventListener('submit', function(e) {
    // Debug trước khi submit
    const formData = new FormData(this);
    console.log('Form data before submit:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
});
</script>

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
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    padding: 30px;
    margin-top: 20px;
}

/* Page title */
.page-heading h3 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 30px;
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

/* Select styling */
select.form-control {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath fill='%23343a40' d='M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 10px center !important;
    background-size: 20px !important;
    padding-right: 40px !important;
  
}

/* Table styles */
.table-responsive {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table {
    background: white;
    margin-bottom: 0;
    border: none;
}

.table th {
    background: #4a90e2 !important;
    color: white !important;
    font-weight: 600 !important;
    padding: 15px !important;
    border: none !important;
    font-size: 14px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}

.table td {
    padding: 15px !important;
    border: 1px solid #e9ecef !important;
    vertical-align: middle !important;
    font-size: 14px !important;
    color: #2c3e50 !important;
}

/* Checkbox styling */
.form-check-input {
    width: 20px !important;
    height: 20px !important;
    margin-right: 10px !important;
    cursor: pointer !important;
    border: 2px solid #3498db !important;
    border-radius: 4px !important;
}

.form-check-input:checked {
    background-color: #3498db !important;
    border-color: #3498db !important;
}

.form-check-label {
    cursor: pointer !important;
    font-size: 14px !important;
    color: #2c3e50 !important;
    margin-left: 5px !important;
}

/* Button styles */
.button {
    height: 45px !important;
    padding: 0 25px !important;
    border-radius: 8px !important;
    font-weight: 500 !important;
    font-size: 15px !important;
    transition: all 0.3s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    min-width: 120px !important;
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

.button-danger {
    background: transparent !important;
    border: 2px solid #e74c3c !important;
    color: #e74c3c !important;
}

.button-danger:hover {
    background: #e74c3c !important;
    color: #fff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3) !important;
}

/* Hover effects */
tr:hover {
    background-color: #f8f9fa !important;
}

/* Responsive */
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
    
    .table th, .table td {
        padding: 10px !important;
    }
    
    .button {
        width: 100% !important;
        margin: 5px 0 !important;
    }
}
</style>
