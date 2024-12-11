<?php 
include "./view/home/sideheader.php";
?>


<!-- Content Body Start -->
<div class="content-body">
    <!-- Thêm thông báo nếu có -->
    <?php if(isset($thongbao)): ?>
        <div class="alert alert-info"><?= $thongbao ?></div>
    <?php endif; ?>

    <!-- <link rel="stylesheet" href="assets/css/stylecolor.css"> -->

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Quản lý khuyến mãi <span>/ Khuyến mãi</span></h3>
            </div>
        </div><!-- Page Heading End -->
    </div><!-- Page Headings End -->

    <?php if(isset($suatc) && ($suatc) != ""): ?>
        <p style="color: red; text-align: center;"><?= $suatc ?></p>
    <?php endif; ?> 

    <div class="row">
        <div class="col-12 mb-30">
            <div class="news-item">
                <div class="content">
                    <div class="categories">
                        <a href="index.php?act=themkhuyenmai" class="product">Thêm khuyến mãi</a>
                    </div>
                </div>
            </div>
            <!--Order List Start-->
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-vertical-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên khuyến mãi</th>
                                <th>Giá trị</th>
                                <th>Ngày kết thúc</th>
                                <th>Mô tả</th>
                                <th>Quản lý</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($loadkhuyenmai) && is_array($loadkhuyenmai)) {
                                foreach ($loadkhuyenmai as $km) { 
                                    extract($km);
                            ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $ten_km ?></td>
                                    <td><?= $gia_tri ?></td>
                                    <td><?= $ngay_ket_thuc ?></td>
                                    <td><?= $mota ?></td>
                                    <td>
                                        <div class="table-action-buttons">
                                            <a class="edit button button-box button-xs button-info" 
                                               href="index.php?act=suakhuyenmai&ids=<?= $id ?>">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <a class="delete button button-box button-xs button-danger" 
                                               href="index.php?act=xoakhuyenmai&idxoa=<?= $id ?>"
                                               onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                                <i class="zmdi zmdi-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có dữ liệu</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Order List End-->
        </div>
    </div>
</div><!-- Content Body End -->

<!-- Thêm thông báo kết quả -->
<?php if(isset($suatc)): ?>
    <div class="alert alert-success"><?= $suatc ?></div>
<?php endif; ?>

<?php if(isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>