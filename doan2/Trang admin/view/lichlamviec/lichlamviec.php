<?php
include "./view/home/sideheader.php";

// Lấy danh sách rạp
$dsrap = getAllRap();

// Lấy thông tin rạp được chọn
$selected_rap = isset($_GET['rap_id']) ? $_GET['rap_id'] : '';

// Lấy từ khóa tìm kiếm
$search_name = isset($_GET['search']) ? $_GET['search'] : '';

// Lấy thông tin tuần được chọn 
$current_week = isset($_GET['week']) ? $_GET['week'] : date('Y-m-d');
$week_start = date('Y-m-d', strtotime('monday this week', strtotime($current_week)));
$week_end = date('Y-m-d', strtotime('sunday this week', strtotime($current_week)));

// Load lịch làm việc
$loadlichlamviec = loadall_lichlamviec($selected_rap, $week_start, $week_end);

// Tách thành 2 mảng riêng cho quản lý và nhân viên
$lich_quanly = array_filter($loadlichlamviec, function ($item) {
    return $item['vai_tro'] == 'Quản lý';
});

$lich_nhanvien = array_filter($loadlichlamviec, function ($item) {
    return $item['vai_tro'] == 'Nhân viên';
});

// Gộp lịch làm việc theo nhân viên
$nhanvien_schedule = [];
foreach ($loadlichlamviec as $lich) {
    // Tạo key duy nhất cho mỗi nhân viên/quản lý
    if ($lich['vai_tro'] == 'Quản lý') {
        $key = 'QL_' . $lich['id_taikhoan'] . '_' . $lich['id_rap'];
    } else {
        $key = 'NV_' . $lich['ten_nguoi_lam'] . '_' . $lich['id_rap'];
    }

    if (!isset($nhanvien_schedule[$key])) {
        $nhanvien_schedule[$key] = [
            'ten_nguoi_lam' => $lich['ten_nguoi_lam'],
            'vai_tro' => $lich['vai_tro'],
            'id' => $lich['id'],
            'id_rap' => $lich['id_rap'],
            'tenrap' => $lich['tenrap'],
            'lich' => []
        ];
    }

    if ($lich['ngay_lam_viec']) {
        $nhanvien_schedule[$key]['lich'][$lich['ngay_lam_viec']][] = [
            'id' => $lich['id'],
            'ca' => $lich['ca_lam_viec'],
            'cong_viec' => $lich['ten_cong_viec']
        ];
    }
}

// Lọc theo tên nếu có
if ($search_name) {
    $nhanvien_schedule = array_filter($nhanvien_schedule, function ($nv) use ($search_name) {
        return stripos($nv['ten_nguoi_lam'], $search_name) !== false;
    });
}

// Lọc theo rạp nếu có
if ($selected_rap) {
    $nhanvien_schedule = array_filter($nhanvien_schedule, function ($nv) use ($selected_rap) {
        return $nv['id_rap'] == $selected_rap;
    });
}

if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
    echo "<script>alert('Cập nhật lịch làm việc thành công!');</script>";
    unset($_SESSION['update_success']); // Xóa flag sau khi đã hiển thị
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

<div class="content-body">
    <!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->

    <!-- Form lọc -->
    <div class="row mb-30">
        <div class="col-12">
            <form action="" method="GET" class="d-flex align-items-center">
                <input type="hidden" name="act" value="lichlamviec">

                <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
                    <!-- Select box chọn rạp -->
                    <div class="mr-15" style="width: 200px;">
                        <select name="rap_id" class="form-control">
                            <option value="">Tất cả rạp</option>
                            <?php foreach ($dsrap as $rap): ?>
                                <option value="<?= $rap['id'] ?>" <?= ($selected_rap == $rap['id']) ? 'selected' : '' ?>>
                                    <?= $rap['tenrap'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>

                <!-- Input chọn tuần -->
                <div class="mr-15">
                    <input type="date" name="week" class="form-control"
                        value="<?= $current_week ?>"
                        onchange="this.form.submit()">
                </div>

                <!-- Nút tìm kiếm -->
                <div class="mr-15">
                    <input type="text" name="search" class="form-control"
                        placeholder="Tìm kiếm theo tên"
                        value="<?= htmlspecialchars($search_name) ?>">
                </div>

                <div>
                    <button type="submit" class="button button-primary">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hiển thị thông tin tuần -->
    <div class="row mb-20">
        <div class="col-12">
            <h5>Lịch làm việc từ <?= date('d/m/Y', strtotime($week_start)) ?>
                đến <?= date('d/m/Y', strtotime($week_end)) ?></h5>
        </div>
    </div>

    <!-- Nút thêm mới -->
    <div class="row mb-20">
        <div class="col-12">
            <a href="index.php?act=themvitriquanly" class="button button-primary mr-10">Thêm lịch quản lý</a>
            <a href="index.php?act=themlichnhanvien" class="button button-primary">Thêm lịch nhân viên</a>
        </div>
    </div>

    <!-- Bảng cho Quản lý -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="table-title">Lịch làm việc Quản lý</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Quản lý</th>
                            <?php
                            $current = strtotime($week_start);
                            for ($i = 0; $i < 7; $i++):
                                $date = date('d/m', $current);
                                $thu = $i + 2;
                                if ($thu == 8) $thu = "CN";
                            ?>
                                <th class="text-center">
                                    Thứ <?= $thu ?><br>
                                    <?= $date ?>
                                </th>
                            <?php
                                $current = strtotime('+1 day', $current);
                            endfor;
                            ?>
                            <!-- <th class="text-center">Thao tác</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $quanly_list = [];
                        foreach ($loadlichlamviec as $lich) {
                            if ($lich['vai_tro'] == 'Quản lý') {
                                $key = $lich['id_taikhoan'] . '_' . $lich['id_rap'];
                                if (!isset($quanly_list[$key])) {
                                    $quanly_list[$key] = [
                                        'ten' => $lich['ten_nguoi_lam'],
                                        'rap' => $lich['tenrap'],
                                        'id_rap' => $lich['id_rap'],
                                        'id_taikhoan' => $lich['id_taikhoan'],
                                        'lich' => []
                                    ];
                                }
                                $quanly_list[$key]['lich'][$lich['ngay_lam_viec']] = $lich;
                            }
                        }

                        foreach ($quanly_list as $ql):
                        ?>
                            <tr>
                                <td>
                                    <div class="employee-info d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= $ql['ten'] ?></strong>
                                            <small class="text-muted"><?= $ql['rap'] ?></small>
                                        </div>
                                        <div class="btn-group">
                                            <a href="index.php?act=updatequanly&ten=<?= urlencode($ql['ten']) ?>&rap=<?= $ql['id_rap'] ?>"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <?php
                                $current = strtotime($week_start);
                                for ($i = 0; $i < 7; $i++):
                                    $date = date('Y-m-d', $current);
                                ?>
                                    <td class="text-center">
                                        <?php if (isset($ql['lich'][$date])): ?>
                                            <div class="shift shift-manager">
                                                <div class="shift-time">Full ca</div>
                                                <div class="shift-task"><?= $ql['lich'][$date]['ten_cong_viec'] ?></div>
                                                <button type="button"
                                                    class="btn btn-danger btn-sm btn-delete-shift"
                                                    onclick="confirmDelete('<?= $ql['lich'][$date]['id'] ?>', 
                                                             '<?= htmlspecialchars($ql['ten']) ?>', 
                                                             '<?= date('d/m/Y', strtotime($date)) ?>')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                <?php
                                    $current = strtotime('+1 day', $current);
                                endfor;
                                ?>
                                <!-- <td class="text-center">
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="confirmDelete('<?= $ql['lich'][$date]['id'] ?? '' ?>', '<?= htmlspecialchars($ql['ten']) ?>')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bảng cho Nhân viên -->
    <div class="row">
        <div class="col-12">
            <h5 class="table-title">Lịch làm việc Nhân viên</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 200px;">Nhân viên</th>
                            <?php
                            $current = strtotime($week_start);
                            for ($i = 0; $i < 7; $i++):
                                $date = date('d', $current);
                                $thu = $i + 2;
                                if ($thu == 8) $thu = "CN";
                            ?>
                                <th class="text-center">
                                    Thứ <?= $thu ?><br>
                                    <?= $date ?>
                                </th>
                            <?php
                                $current = strtotime('+1 day', $current);
                            endfor;
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($nhanvien_schedule as $nv):
                            if ($nv['vai_tro'] == 'Nhân viên'):
                        ?>
                                <tr>
                                    <td>
                                        <div class="employee-info d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?= $nv['ten_nguoi_lam'] ?></strong>
                                                <small class="text-muted"><?= $nv['tenrap'] ?></small>
                                            </div>
                                            <div class="btn-group">
                                                <?php if ($nv['vai_tro'] == 'Nhân viên'): ?>
                                                    <a href="index.php?act=updatenhanvien&ten=<?= urlencode($nv['ten_nguoi_lam']) ?>&rap=<?= $nv['id_rap'] ?>"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                    $current = strtotime($week_start);
                                    for ($i = 0; $i < 7; $i++):
                                        $date = date('Y-m-d', $current);
                                    ?>
                                        <td class="text-center">
                                            <?php if (isset($nv['lich'][$date])):
                                                foreach ($nv['lich'][$date] as $ca): ?>
                                                    <div class="shift <?= $nv['vai_tro'] == 'Quản lý' ? 'shift-manager' : 'shift-staff' ?>">
                                                        <div class="shift-time"><?= $ca['ca'] ?></div>
                                                        <div class="shift-task"><?= $ca['cong_viec'] ?></div>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-delete-shift"
                                                            onclick="confirmDelete(<?= $ca['id'] ?>, '<?= htmlspecialchars($nv['ten_nguoi_lam']) ?>', '<?= htmlspecialchars($ca['ca']) ?>')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                            <?php endforeach;
                                            endif; ?>
                                        </td>
                                    <?php
                                        $current = strtotime('+1 day', $current);
                                    endfor;
                                    ?>
                                    <!-- <td class="text-center">
                                <button type="button" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="confirmDelete('<?= $nv['id'] ?>', '<?= $nv['ten_nguoi_lam'] ?>')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td> -->
                                </tr>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    /* Reset và override styles cho content-body */
    .content-body {
        padding: 30px !important;
        margin-left: 280px !important;
        /* Điều chỉnh theo width của sidebar */
        background: #f5f6fa !important;
        min-height: 100vh !important;
        width: calc(100% - 280px) !important;
        /* Điều chỉnh theo width của sidebar */
        position: relative !important;
    }

    /* Table styles với specificity cao hơn */
    .content-body .table {
        border: 2px solid #dfe6e9 !important;
        background: white !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        margin-bottom: 1rem !important;
    }

    .content-body .table th {
        background: #4a90e2 !important;
        color: white !important;
        font-weight: 600 !important;
        padding: 15px 12px !important;
        border: 1px solid #2980b9 !important;
        font-size: 13px !important;
        text-align: center !important;
    }

    .content-body .table td {
        border: 1px solid #dfe6e9 !important;
        padding: 12px !important;
        vertical-align: top !important;
    }

    /* Employee info styles */
    .content-body .employee-info {
        display: flex !important;
        flex-direction: column !important;
        gap: 4px !important;
    }

    .content-body .employee-info strong {
        color: #2c3e50 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
    }

    /* Shift styles */
    .content-body .shift {
        border: 1px solid #c0c6cc !important;
        padding: 8px 10px !important;
        margin: 4px 0 !important;
        border-radius: 4px !important;
        position: relative !important;
        padding-right: 30px !important;
    }

    .content-body .shift-manager {
        border-left: 4px solid #3498db !important;
        background: #ebf5ff !important;
    }

    .content-body .shift-staff {
        border-left: 4px solid #2ecc71 !important;
        background: #edfff5 !important;
    }

    /* Form controls */
    .content-body .form-control {
        height: 38px !important;
        border: 2px solid #bdc3c7 !important;
        border-radius: 6px !important;
        padding: 0 12px !important;
        font-size: 14px !important;
        background: white !important;
    }

    .content-body .button {
        height: 38px !important;
        padding: 0 16px !important;
        border-radius: 6px !important;
        font-weight: 500 !important;
        font-size: 14px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .content-body .button-primary {
        background: #3498db !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3) !important;
    }

    /* Spacing */
    .content-body .mr-10 {
        margin-right: 10px !important;
    }

    .content-body .mr-15 {
        margin-right: 15px !important;
    }

    .content-body .mb-20 {
        margin-bottom: 20px !important;
    }

    .content-body .mb-30 {
        margin-bottom: 30px !important;
    }

    /* Table title */
    .content-body .table-title {
        color: #2c3e50 !important;
        font-weight: 600 !important;
        margin-bottom: 15px !important;
        padding-left: 10px !important;
        border-left: 5px solid #3498db !important;
        font-size: 18px !important;
    }

    /* Delete button */
    .content-body .btn-delete-shift {
        position: absolute !important;
        right: 5px !important;
        top: 5px !important;
        padding: 2px 5px !important;
        font-size: 12px !important;
        line-height: 1 !important;
        opacity: 0 !important;
        transition: opacity 0.2s !important;
    }

    .content-body .shift:hover .btn-delete-shift {
        opacity: 1 !important;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .content-body {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }
</style>

<script>
    function confirmDelete(id, ten, ca) {
        if (confirm('Bạn có chắc muốn xóa ca ' + ca + ' của ' + ten + '?')) {
            window.location.href = 'index.php?act=xoalichlamviec&idxoa=' + id;
        }
    }
</script>