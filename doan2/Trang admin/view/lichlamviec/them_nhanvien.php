<?php
include "./view/home/sideheader.php";
$rap_list = getAllRap();
$tomorrow = date('Y-m-d', strtotime('tomorrow'));

// Hiển thị thông báo thành công nếu có
if (isset($suatc)) {
    echo '<div class="alert alert-success" style="margin: 20px; padding: 15px; background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: 4px;">
        ' . $suatc . '
    </div>';
}
?>

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
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
        padding: 15px;
        background: #3f87f5;
        color: white;
        font-weight: 500;
        text-align: center;
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

    .schedule-checkbox input[type="checkbox"]:checked+label {
        background: #3f87f5;
    }

    .schedule-checkbox input[type="checkbox"]:checked+label:after {
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
</style>

<div class="main-content-wrap">

    <div class="container-fluid">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Thêm lịch làm việc nhân viên</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-30">
                <form action="index.php?act=themlichnhanvien" method="post">
                    <div class="card-schedule">
                        <div class="row">
                            <!-- Thông tin nhân viên -->
                            <div class="col-md-6 mb-20">
                                <label class="form-label">Tên nhân viên</label>
                                <input type="text" class="form-control" name="ten_nhanvien" required>
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

                            <!-- Ngày bắt đầu và số tuần -->
                            <div class="col-md-4 mb-20">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="date"
                                    class="form-control"
                                    name="ngay_bat_dau"
                                    min="<?= $tomorrow ?>"
                                    value="<?= $tomorrow ?>"
                                    required>
                            </div>

                            <div class="col-md-4 mb-20">
                                <label class="form-label">Số tuần</label>
                                <input type="number"
                                    class="form-control"
                                    name="so_tuan"
                                    min="1"
                                    value="1"
                                    required>
                            </div>

                            <!-- Công việc -->
                            <div class="col-md-4 mb-20">
                                <label class="form-label">Công việc</label>
                                <select class="form-control" name="ten_cong_viec" required>
                                    <option value="">Chọn công việc</option>
                                    <option value="Nhân viên bán vé">Nhân viên bán vé</option>
                                    <option value="Nhân viên phòng chiếu">Nhân viên phòng chiếu</option>
                                    <option value="Nhân viên vệ sinh">Nhân viên vệ sinh</option>
                                    <option value="Nhân viên bảo vệ">Nhân viên bảo vệ</option>
                                    <option value="Nhân viên phục vụ đồ ăn và thức uống">Nhân viên phục vụ đồ ăn và thức uống</option>
                                    <option value="Kỹ thuật viên">Kỹ thuật viên</option>
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
                                        <?php for ($i = 0; $i < 7; $i++): ?>
                                            <th class="day-header"><!-- Sẽ được JavaScript điền vào --></th>
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

                                    foreach ($ca_lam as $ca => $ten_ca): ?>
                                        <tr>
                                            <td><strong><?= $ten_ca ?></strong></td>
                                            <?php for ($thu = 0; $thu < 7; $thu++): ?>
                                                <td>
                                                    <div class="schedule-checkbox">
                                                        <input type="checkbox"
                                                            id="ca_<?= $ca ?>_<?= $thu ?>"
                                                            name="lich[<?= $thu ?>][<?= $ca ?>]"
                                                            value="1">
                                                        <label for="ca_<?= $ca ?>_<?= $thu ?>"></label>
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
                                <!-- Nút quay về -->
                                <a href="index.php?act=lichlamviec" class="button button-outline button-danger">
                                    <i class="zmdi zmdi-arrow-left mr-1"></i>Quay về danh sách
                                </a>

                                <!-- Nút thêm lịch -->
                                <button type="submit" name="them_lich" class="button button-outline button-primary">
                                    <i class="zmdi zmdi-plus mr-1"></i>Thêm lịch làm việc
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
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const headerDays = document.querySelectorAll('.day-header');

        function updateTableHeaders(selectedDate) {
            // Cập nhật tiêu đề các cột với ngày cụ thể
            headerDays.forEach((header, index) => {
                const currentDate = new Date(selectedDate);
                currentDate.setDate(currentDate.getDate() + index);

                const dayOfWeek = currentDate.getDay();
                const dayOfMonth = currentDate.getDate();
                const month = currentDate.getMonth() + 1;

                let dayName;
                switch (dayOfWeek) {
                    case 0:
                        dayName = "Chủ nhật";
                        break;
                    case 1:
                        dayName = "Thứ 2";
                        break;
                    case 2:
                        dayName = "Thứ 3";
                        break;
                    case 3:
                        dayName = "Thứ 4";
                        break;
                    case 4:
                        dayName = "Thứ 5";
                        break;
                    case 5:
                        dayName = "Thứ 6";
                        break;
                    case 6:
                        dayName = "Thứ 7";
                        break;
                }

                header.textContent = `${dayName} (${dayOfMonth}/${month})`;
            });
        }

        function updateCheckboxes(selectedDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            checkboxes.forEach(checkbox => {
                const dayIndex = parseInt(checkbox.id.split('_')[2]);
                const checkDate = new Date(selectedDate);
                checkDate.setDate(checkDate.getDate() + dayIndex);

                if (checkDate < today) {
                    checkbox.disabled = true;
                    checkbox.checked = false;
                    checkbox.parentElement.style.opacity = '0.5';
                } else {
                    checkbox.disabled = false;
                    checkbox.parentElement.style.opacity = '1';
                }
            });
        }

        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate <= today) {
                alert('Vui lòng chọn ngày từ ngày mai trở đi');
                this.value = '';
                return;
            }

            updateTableHeaders(selectedDate);
            updateCheckboxes(selectedDate);
        });

        // Set ngày mặc định là ngày mai
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.value = tomorrow.toISOString().split('T')[0];
        updateTableHeaders(tomorrow);
        updateCheckboxes(tomorrow);
    });
</script>