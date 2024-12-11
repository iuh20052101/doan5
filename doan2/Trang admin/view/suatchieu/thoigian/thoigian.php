<?php include "./view/home/sideheader.php"; ?>
<div class="content-body">
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3 class="title">Quản Lý Suất Chiếu<span>/Suất Chiếu</span></h3>
            </div>
        </div>
    </div>

    <!-- Nút chọn rạp và phòng -->
    <?php if (isset($_SESSION['user1']) && $_SESSION['user1']['vai_tro'] == 2): ?>
        <div class="col-12 mb-30">
            <div class="box">
                <div class="box-body">
                    <ul class="nav nav-pills mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['rap_id']) ? 'active' : '' ?>"
                                href="index.php?act=thoigian">
                                Tất cả rạp
                            </a>
                        </li>
                        <?php foreach ($loadrap as $rap): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle <?= (isset($_GET['rap_id']) && $_GET['rap_id'] == $rap['id']) ? 'active' : '' ?>"
                                    data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?= $rap['tenrap'] ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="index.php?act=thoigian&rap_id=<?= $rap['id'] ?>">
                                        Tất cả phòng
                                    </a>
                                    <?php
                                    $phong_list = load_phong_by_rap($rap['id']);
                                    foreach ($phong_list as $phong):
                                    ?>
                                        <a class="dropdown-item <?= (isset($_GET['id_phong']) && $_GET['id_phong'] == $phong['id']) ? 'active' : '' ?>"
                                            href="index.php?act=thoigian&rap_id=<?= $rap['id'] ?>&id_phong=<?= $phong['id'] ?>">
                                            <?= $phong['name'] ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
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
                    <a href="index.php?act=themthoigian" class="product">Thêm suất chiếu</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-vertical-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Phim</th>
                        <th>Phòng chiếu</th>
                        <th>Ngày Chiếu</th>
                        <th>Giờ chiếu</th>
                        <th>Rạp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loadkgc)): ?>
                        <?php foreach ($loadkgc as $gio): ?>
                            <tr>
                                <td>#<?= $gio['id'] ?></td>
                                <td><?= $gio['tieu_de'] ?></td>
                                <td><?= $gio['name'] ?></td>
                                <td><?= date('d/m/Y', strtotime($gio['ngay_chieu'])) ?></td>
                                <td><?= $gio['thoi_gian_chieu'] ?></td>
                                <td><?= $gio['tenrap'] ?></td>
                                <td class="action h4">
                                    <div class="table-action-buttons">
                                        <a class="edit button button-box button-xs button-info"
                                            href="index.php?act=suathoigian&ids=<?= $gio['id'] ?>">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Bạn có muốn xóa không?')"
                                            class="delete button button-box button-xs button-danger"
                                            href="index.php?act=xoathoigian&idxoa=<?= $gio['id'] ?>">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Không có dữ liệu</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Main Container với gradient màu đẹp */
    .content-body {
        padding: 2rem;
        background: linear-gradient(135deg, #f6f8ff 0%, #ffffff 100%);
        min-height: 100vh;
        position: relative;
    }

    .content-body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(45deg, #4158d0, #c850c0, #ffcc70);
        opacity: 0.05;
        pointer-events: none;
    }

    /* Header với hiệu ứng gradient text */
    .page-heading .title {
        font-size: 2rem;
        background: linear-gradient(45deg, #4158d0, #c850c0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    /* Box với hiệu ứng glass morphism */
    .box {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }

    /* Nav Pills với gradient */
    .nav-pills .nav-link {
        background: linear-gradient(45deg, #f6f8ff, #ffffff);
        border: 1px solid #e1e5f1;
        color: #4158d0;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(45deg, #4158d0, #c850c0);
        color: white;
        box-shadow: 0 4px 15px rgba(65, 88, 208, 0.3);
    }

    .nav-pills .nav-link:hover:not(.active) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(65, 88, 208, 0.1);
    }

    /* Nút thêm suất chiếu với gradient */
    .categories .product {
        background: linear-gradient(45deg, #4158d0, #c850c0);
        border: none;
        padding: 1rem 2rem;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(65, 88, 208, 0.3);
    }

    .categories .product:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(65, 88, 208, 0.4);
    }

    /* Table với hiệu ứng hover đẹp */
    .table-responsive {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    }

    .table thead th {
        background: linear-gradient(45deg, #f6f8ff, #ffffff);
        color: #4158d0;
        font-weight: 700;
        border-bottom: 2px solid rgba(65, 88, 208, 0.1);
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(65, 88, 208, 0.1);
    }

    .table tbody tr:hover {
        background: linear-gradient(45deg, #f6f8ff, #ffffff);
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(65, 88, 208, 0.1);
    }

    /* Action Buttons với gradient */
    .button-box {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .button-info {
        background: linear-gradient(45deg, #4158d0, #5d87ff);
        color: white;
    }

    .button-danger {
        background: linear-gradient(45deg, #ff4d4d, #f73859);
        color: white;
    }

    .button-box:hover {
        transform: translateY(-3px) rotate(8deg);
        box-shadow: 0 6px 20px rgba(65, 88, 208, 0.2);
    }

    /* Animation cho icons */
    .zmdi {
        transition: all 0.3s ease;
    }

    .button-box:hover .zmdi {
        transform: scale(1.2);
    }

    /* Dropdown menu với glass morphism */
    .dropdown-menu {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    }

    .dropdown-item:hover {
        background: linear-gradient(45deg, #f6f8ff, #ffffff);
        color: #4158d0;
        transform: translateX(8px);
    }

    /* Custom Scrollbar với gradient */
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #4158d0, #c850c0);
        border-radius: 10px;
    }

    /* Empty state với gradient text */
    .text-center {
        background: linear-gradient(45deg, #4158d0, #c850c0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
    }

    /* Animation cho loading */
    @keyframes gradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .loading {
        background: linear-gradient(45deg, #4158d0, #c850c0, #ffcc70);
        background-size: 200% 200%;
        animation: gradient 2s ease infinite;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .content-body::before {
            height: 150px;
        }

        .page-heading .title {
            font-size: 1.5rem;
        }
    }
</style>