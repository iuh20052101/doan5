<?php include "./view/home/sideheader.php"; ?>
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Quản Lý Bình Luận<span>/ Bình Luận</span></h3>
            </div>
        </div>
    </div>

    <!-- Nút chọn phim -->
    <div class="col-12 mb-30">
        <div class="box">
            <div class="box-body">
                <ul class="nav nav-pills mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?=!isset($_GET['id_phim']) ? 'active' : ''?>" 
                           href="index.php?act=QLfeed">
                            Tất cả phim
                        </a>
                    </li>
                    <?php foreach ($loadphim as $phim): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link <?=(isset($_GET['id_phim']) && $_GET['id_phim'] == $phim['id']) ? 'active' : ''?>" 
                               href="index.php?act=QLfeed&id_phim=<?=$phim['id']?>">
                                <?=$phim['tieu_de']?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-12 mb-30">
        <div class="box">
            <div class="box-body">
                <table class="table table-vertical-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Tên phim</th>
                            <th>Nội dung</th>
                            <th>Ngày bình luận</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($listbl)): ?>
                            <?php foreach ($listbl as $bl): ?>
                                <tr>
                                    <td><?=$bl['id']?></td>
                                    <td><?=$bl['name']?></td>
                                    <td><?=$bl['tieu_de']?></td>
                                    <td><?=$bl['noidung']?></td>
                                    <td><?=date('d/m/Y H:i', strtotime($bl['ngaybinhluan']))?></td>
                                    <td>
                                        <div class="table-action-buttons">
                                            <a onclick="return confirm('Bạn có muốn xóa không?')" 
                                               class="delete button button-box button-xs button-danger" 
                                               href="index.php?act=xoabl&id=<?=$bl['id']?>">
                                                <i class="zmdi zmdi-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có dữ liệu</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Phân trang -->
               
            </div>
        </div>
    </div>
</div>

<style>
.nav-pills .nav-link.active {
    background-color: #007bff;
    color: white;
}

.box {
    background: #fff;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.pagination {
    margin-bottom: 0;
}

.table-action-buttons .button {
    margin: 0 3px;
}

.button-danger {
    background-color: #dc3545;
    color: white;
}

.button-danger:hover {
    background-color: #c82333;
}
</style>