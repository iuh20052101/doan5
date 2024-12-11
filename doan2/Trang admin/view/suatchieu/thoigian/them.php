<?php include "./view/home/sideheader.php"; ?>
<div class="content-body">


    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Quản Lý Suất Chiếu<span>/ Thêm Suất chiếu</span></h3>
            </div>
        </div>
    </div>

    <!-- Hiển thị thông báo -->
    <?php if (isset($error) && $error != ""): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="index.php?act=themthoigian" method="POST">
        <div class="add-edit-product-wrap col-12">
            <div class="add-edit-product-form">
                <!-- Phần select rạp và phòng -->
                <div class="col-lg-12 col-12 mb-30">
                    <div class="box">
                        <div class="box-body">
                            <ul class="nav nav-pills mb-4">
                                <!-- Admin can choose all cinemas -->
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" id="all_rap">Chọn Rạp</a>
                                </li>

                                <?php if ($_SESSION['user1']['vai_tro'] == 2): // Role is admin 
                                ?>
                                    <?php foreach ($loadrap as $rap): ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle"
                                                data-toggle="dropdown" href="#"
                                                data-rap-id="<?= $rap['id'] ?>">
                                                <?= $rap['tenrap'] ?>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"
                                                    onclick="selectRapAndPhong('<?= $rap['id'] ?>', '')">
                                                    Tất cả phòng
                                                </a>
                                                <?php foreach (load_phong_by_rap($rap['id']) as $phong): ?>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="selectRapAndPhong('<?= $rap['id'] ?>', '<?= $phong['id'] ?>')">
                                                        <?= $phong['name'] ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>

                                <?php elseif ($_SESSION['user1']['vai_tro'] == 3): // Role is manager 
                                ?>
                                    <?php
                                    // Load only the rap assigned to the manager
                                    $rap_id = $_SESSION['user1']['rap_id'];
                                    $rap = loadone_rap($rap_id);  // Assume this function fetches rap by ID
                                    ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle"
                                            data-toggle="dropdown" href="#"
                                            data-rap-id="<?= $rap['id'] ?>">
                                            <?= $rap['tenrap'] ?>
                                        </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"
                                                onclick="selectRapAndPhong('<?= $rap['id'] ?>', '')">
                                                Tất cả phòng
                                            </a>
                                            <?php foreach (load_phong_by_rap($rap['id']) as $phong): ?>
                                                <a class="dropdown-item" href="#"
                                                    onclick="selectRapAndPhong('<?= $rap['id'] ?>', '<?= $phong['id'] ?>')">
                                                    <?= $phong['name'] ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" name="rap_id" id="selected_rap">
                <input type="hidden" name="id_phong" id="selected_phong">


                <div class="row">
                    <!-- Select Lịch chiếu -->
                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Chọn Lịch Chiếu</span>
                        <select name="id_lc" id="lichchieu_select" class="form-control" required>
                            <option value="">Chọn Lịch Chiếu</option>
                            <?php foreach ($loadlc as $lc):
                                if (strtotime($lc['ngay_chieu']) >= strtotime('tomorrow')): ?>
                                    <option value="<?= $lc['id'] ?>" data-rap="<?= $lc['rap_id'] ?>">
                                        <?= $lc['tieu_de'] ?> - <?= date('d/m/Y', strtotime($lc['ngay_chieu'])) ?>
                                    </option>
                            <?php endif;
                            endforeach; ?>
                        </select>
                    </div>

                    <!-- Giờ chiếu -->
                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Giờ chiếu</span>
                        <div class="time-slots">
                            <div class="time-slot-group mb-2">
                                <div class="d-flex align-items-center">
                                    <input class="form-control mr-2" type="time" name="tgc[]" required>
                                    <button type="button" class="button button-xs button-info add-time-slot">
                                        <i class="zmdi zmdi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row">
                    <div class="col-lg-6 col-12 mb-30">
                        <button type="submit" name="them" class="button button-outline button-primary mb-10 ml-10 mr-0">Thêm</button>
                        <a href="index.php?act=thoigian" class="button button-outline button-primary mb-10 ml-10 mr-0">Danh sách</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeSlots = document.querySelector('.time-slots');

        function createTimeSlot() {
            const div = document.createElement('div');
            div.className = 'time-slot-group mb-2';
            div.innerHTML = `
            <div class="d-flex align-items-center">
                <input class="form-control mr-2" type="time" name="tgc[]" required>
                <button type="button" class="button button-xs button-danger remove-time-slot">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        `;
            return div;
        }

        document.querySelector('.add-time-slot').addEventListener('click', () =>
            timeSlots.appendChild(createTimeSlot()));

        timeSlots.addEventListener('click', e => {
            if (e.target.closest('.remove-time-slot')) {
                e.target.closest('.time-slot-group').remove();
            }
        });
    });

    function selectRapAndPhong(rapId, phongId) {
        document.getElementById('selected_rap').value = rapId;
        document.getElementById('selected_phong').value = phongId;

        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
            if (link.dataset.rapId === rapId) link.classList.add('active');
        });

        const lichchieuSelect = document.getElementById('lichchieu_select');
        Array.from(lichchieuSelect.options).forEach(option => {
            option.style.display = option.value === '' || option.dataset.rap === rapId ? '' : 'none';
        });
        lichchieuSelect.value = '';

        if (phongId) {
            const phongName = event.target.textContent.trim();
            const rapLink = document.querySelector(`[data-rap-id="${rapId}"]`);
            rapLink.textContent = `${rapLink.textContent.split(' - ')[0]} - ${phongName}`;
        }
    }

    document.getElementById('all_rap').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('selected_rap').value = '';
        document.getElementById('selected_phong').value = '';
        this.classList.add('active');

        document.querySelectorAll('.nav-link.dropdown-toggle').forEach(link => {
            link.classList.remove('active');
            link.textContent = link.textContent.split(' - ')[0];
        });

        const lichchieuSelect = document.getElementById('lichchieu_select');
        lichchieuSelect.value = '';
        Array.from(lichchieuSelect.options).forEach(option => option.style.display = '');
    });
</script>