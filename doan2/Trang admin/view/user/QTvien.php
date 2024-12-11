<?php include "./view/home/sideheader.php"; ?>

<div class="content-body">
    <link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Quản Lý Tài Khoản / <span>Tài Khoản Nhân Viên</span></h3>
            </div>
        </div>
    </div>

    <?php if (isset($suatc) && ($suatc) != "") {
        echo '<p style="color: red; text-align: center;">' . $suatc . '</p>';
    } ?>

    <!-- Thêm phần lọc theo rạp -->
    <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['id_rap']) ? 'active' : '' ?>"
                                href="index.php?act=QTvien">
                                Tất cả rạp
                            </a>
                        </li>
                        <?php foreach ($loadrap as $rap): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= (isset($_GET['id_rap']) && $_GET['id_rap'] == $rap['id']) ? 'active' : '' ?>"
                                    href="index.php?act=QTvien&id_rap=<?= $rap['id'] ?>">
                                    <?= $rap['tenrap'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Danh sách nhân viên -->
    <div class="col-12 mb-30">
        <div class="news-item">
            <div class="content">
                <div class="categories">
                    <a href="index.php?act=themuser" class="product">Thêm Tài Khoản Nhân Viên</a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th># ID</th>
                        <th>Tên Nhân Viên</th>
                        <th>Tài Khoản</th>
                        <th>Mật khẩu</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Rạp</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($listtaikhoan)):
                        foreach ($listtaikhoan as $taikhoan):
                            extract($taikhoan);
                            $linksua = "index.php?act=suatk&idsua=" . $id;
                            $linkxoa = "index.php?act=xoatk&idxoa=" . $id;
                    ?>
                            <tr>
                                <td>#<?= $id ?></td>
                                <td><?= $name ?></td>
                                <td><?= $user ?></td>
                                <td><?= $pass ?></td>
                                <td><?= $email ?></td>
                                <td><?= $phone ?></td>
                                <td><?= $dia_chi ?></td>
                                <td><?= $tenrap ?? 'Chưa phân công' ?></td>
                                <td>
                                    <span class="badge badge-danger">Nhân Viên</span>
                                </td>
                                <td class="action h4">
                                    <div class="table-action-buttons">
                                        <a class="edit button button-box button-xs button-info" href="<?= $linksua ?>">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?')"
                                            class="delete button button-box button-xs button-danger"
                                            href="<?= $linkxoa ?>">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else:
                        ?>
                        <tr>
                            <td colspan="10" class="text-center">Không có nhân viên nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>