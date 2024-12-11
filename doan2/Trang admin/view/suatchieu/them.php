<?php include "./view/home/sideheader.php"; ?>

<div class="content-body">
    <link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Lịch Chiếu <span>/ Thêm Lịch Chiếu</span></h3>
            </div>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert <?= $error['status'] ? 'alert-success' : 'alert-danger' ?>">
            <?= $error['message'] ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=themlichchieu" method="POST" id="lichChieuForm">
        <div class="add-edit-product-wrap col-12">
            <div class="add-edit-product-form">
                <h4 class="title">Thêm Lịch Chiếu</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Tên Phim</span><br>
                        <select name="id_phim" class="form-control" required>
                            <option value="">Chọn Tên Phim</option>
                            <?php foreach ($loadphim as $phim): ?>
                                <option value="<?= $phim['id'] ?>"><?= $phim['tieu_de'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Chọn rạp</span><br>
                        <?php
                        $user_role = $_SESSION['user1']['vai_tro'];     // Thay thế theo logic của bạn
                        $current_rap_id = $_SESSION['user1']['rap_id']; // ID rạp của nhân viên nếu là nhân viên
                        $is_employee = ($user_role === 1);            // Kiểm tra vai trò có phải nhân viên
                        ?>

                        <select name="id_rap" class="form-control" <?= $is_employee ? 'disabled' : 'required' ?>>
                            <option value="">Chọn rạp</option>
                            <?php foreach ($loadrap as $rap):
                                $selected = ($rap['id'] == $current_rap_id) ? 'selected' : '';
                            ?>
                                <option value="<?= $rap['id'] ?>" <?= $selected ?>><?= $rap['tenrap'] ?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($is_employee): ?>
                            <input type="hidden" name="id_rap" value="<?= $current_rap_id ?>">
                        <?php endif; ?>
                    </div>

                    <div class="col-12 mb-30">
                        <span class="title">Chọn ngày chiếu</span><br>
                        <div id="date-container">
                            <div class="date-row mb-2">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input class="form-control" type="date" name="ngay_chieu[]" required>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-date"
                                            onclick="this.parentElement.parentElement.parentElement.remove()">
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="addDateField()">
                            + Thêm ngày chiếu
                        </button>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 mb-30">
                        <button class="button button-outline button-primary mb-10 ml-10 mr-0"
                            type="submit" name="them">Thêm</button>
                        <a href="index.php?act=QLlichchieu"
                            class="button button-outline button-primary mb-10 ml-10 mr-0">Danh sách</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('lichChieuForm').addEventListener('submit', function(e) {
        const phim = document.querySelector('select[name="id_phim"]').value;
        const rap = document.querySelector('select[name="id_rap"]').value;
        const dates = document.querySelectorAll('input[name="ngay_chieu[]"]');

        if (!phim || !rap) {
            e.preventDefault();
            alert('Vui lòng chọn đầy đủ phim và rạp!');
            return;
        }

        let hasValidDate = false;
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        dates.forEach(date => {
            if (date.value) {
                hasValidDate = true;
                const selectedDate = new Date(date.value);
                if (selectedDate < today) {
                    e.preventDefault();
                    alert('Không thể chọn ngày trong quá khứ!');
                    return;
                }
            }
        });

        if (!hasValidDate) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một ngày chiếu!');
            return;
        }
    });

    function addDateField() {
        const container = document.getElementById('date-container');
        const dateRow = document.createElement('div');
        dateRow.className = 'date-row mb-2';
        dateRow.innerHTML = `
        <div class="row">
            <div class="col-lg-5">
                <input class="form-control" type="date" name="ngay_chieu[]" required>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-danger btn-sm remove-date" 
                        onclick="this.parentElement.parentElement.parentElement.remove()">
                    Xóa
                </button>
            </div>
        </div>
    `;
        container.appendChild(dateRow);
    }
</script>