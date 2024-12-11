<?php include "./view/home/sideheader.php"; ?>
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Quản lý phòng<span>/ Phòng chiếu</span></h3>
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
                        <a class="nav-link <?=!isset($_GET['rap_id']) ? 'active' : ''?>" 
                           href="index.php?act=phong">
                            Tất cả rạp
                        </a>
                    </li>
                    <?php foreach ($loadrap as $rap): ?>
                        <li class="nav-item">
                            <a class="nav-link <?=(isset($_GET['rap_id']) && $_GET['rap_id'] == $rap['id']) ? 'active' : ''?>" 
                               href="index.php?act=phong&rap_id=<?=$rap['id']?>">
                                <?=$rap['tenrap']?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(isset($suatc) && ($suatc)!= ""): ?>
        <p style="color: red; text-align: center"><?=$suatc?></p>
    <?php endif; ?>

    <div class="col-12 mb-30">
        <div class="news-item">
            <div class="content">
                <div class="categories">
                    <a href="index.php?act=themphong" class="product">Thêm Phòng</a>
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
                        <th>Tên phòng</th>
                        <th>Tên rạp</th>
                        <th>Số hàng</th>
                        <th>Số cột</th>
                        <th>Quản Lý</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($loadphong)): ?>
                        <?php foreach ($loadphong as $pc): ?>
                            <tr>
                                <td><?=$pc['id']?></td>
                                <td><?=$pc['name']?></td>
                                <td><?=$pc['tenrap'] ?? 'Chưa có rạp'?></td>
                                <td><?=$pc['so_hang']?></td>
                                <td><?=$pc['so_cot']?></td>
                                <td>
                                    <div class="table-action-buttons">
                                        <a class="edit button button-box button-xs button-info" 
                                           href="index.php?act=suaphong&ids=<?=$pc['id']?>">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <a class="delete button button-box button-xs button-danger" 
                                           href="index.php?act=xoaphong&idxoa=<?=$pc['id']?>"
                                           onclick="return confirm('Bạn có chắc muốn xóa phòng này?')">
                                            <i class="zmdi zmdi-delete"></i>
                                        </a>
                                        <!-- <a class="view button button-box button-xs button-primary" 
                                           href="index.php?act=sodo&id=<?=$pc['id']?>">
                                            <i class="zmdi zmdi-eye"></i>
                                        </a> -->
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
        </div>
    </div>
</div>

