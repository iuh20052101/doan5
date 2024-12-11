<?php
include "./view/home/sideheader.php";
?>
<div class="content-body">
    <link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3 class="title">Quản Lý Lịch Chiếu<span>/ Lịch Chiếu</span></h3>
            </div>
        </div>
    </div>

    <!-- Nút chọn rạp -->
    <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['rap_id']) ? 'active' : '' ?>"
                                href="index.php?act=QLlichchieu">
                                Tất cả rạp
                            </a>
                        </li>
                        <?php foreach ($loadrap as $rap): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (isset($_GET['rap_id']) && $_GET['rap_id'] == $rap['id']) ? 'active' : '' ?>"
                                    href="index.php?act=QLlichchieu&rap_id=<?= $rap['id'] ?>">
                                    <?= $rap['tenrap'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($suatc) && ($suatc) != ""): ?>
        <p style="color: red; text-align: center"><?= $suatc ?></p>
    <?php endif; ?>

    <div class="col-12 mb-30">
        <div class="news-item">
            <div class="content">
                <div class="categories">
                    <a href="index.php?act=themlichchieu" class="product">Thêm Lịch Chiếu</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị lịch chiếu -->
    <?php if (!empty($loadlich)): ?>
        <div class="col-12 mb-30">
            <div class="table-responsive">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Phim</th>
                            <th>Ngày chiếu</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loadlich as $lich): ?>
                            <tr>
                                <td>#<?= $lich['id'] ?></td>
                                <td><?= $lich['tieu_de'] ?></td>
                                <td><?= date('d/m/Y', strtotime($lich['ngay_chieu'])) ?></td>
                                <td class="action h4">
                                    <div class="table-action-buttons">
                                        <a class="edit button button-box button-xs button-info"
                                            href="index.php?act=sualichchieu&idsua=<?= $lich['id'] ?>">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <a class="delete button button-box button-xs button-danger"
                                            href="index.php?act=xoalichchieu&idxoa=<?= $lich['id'] ?>"
                                            onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <p class="text-center">Không có lịch chiếu nào</p>
        </div>
    <?php endif; ?>
</div>