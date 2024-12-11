<?php
include "./view/home/sideheader.php";
// Lấy danh sách rạp
$sql_rap = "SELECT id, tenrap FROM rap";
$rap_list = pdo_query($sql_rap);
?>

<!-- Content Body Start -->
<div class="content-body">
    <link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3> Quản Lý Tài Khoản <span>/ Thêm Tài Khoàn Quản Trị</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->

    </div><!-- Page Headings End -->
    <?php if (isset($suatc) && ($suatc) != "") {
        echo '<p  style="color: red; text-align: center;">' . $suatc . '</p>';
    }
    ?>
    <!-- Add or Edit Product Start -->
    <form action="index.php?act=themuser" method="POST">
        <div class="col-lg-6 col-12 mb-30">

            <div class="add-edit-product-form">

                <h4 class="title">Thêm Người Dùng</h4>

                <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="Tên " name="name"></div>
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="Tài Khoản" name="user"></div>
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="Mật Khẩu" name="pass"></div>
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="Email" name="email"></div>
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="number_format" placeholder="Số Điện Thoại" name="phone"></div>
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="Địa Chỉ" name="dia_chi"></div>
                    <div class="col-lg-6 col-12 mb-30">
                        <?php
                        $user_role = $_SESSION['user1']['vai_tro'];     // Thay thế theo logic của bạn
                        $current_rap_id = $_SESSION['user1']['rap_id']; // ID rạp của nhân viên nếu là nhân viên
                        $is_employee = ($user_role === 3);            // Kiểm tra vai trò có phải nhân viên
                        ?>
                        <?php if ($is_employee): ?>
                            <select class="form-control select1" name="rap_id" disabled style="width: 100%;">
                                <option value="">Chọn rạp</option>
                                <?php
                                foreach ($rap_list as $rap) {
                                    $selected = ($rap['id'] == $rap_id) ? 'selected' : '';
                                    echo "<option value='{$rap['id']}' {$selected}>{$rap['tenrap']}</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="rap_id" value="<?= $rap_id ?>">
                        <?php else: ?>
                            <select class="form-control select1" name="rap_id" required style="width: 100%;">
                                <option value="">Chọn rạp</option>
                                <?php
                                foreach ($rap_list as $rap) {
                                    $selected = ($rap['id'] == $rap_id) ? 'selected' : '';
                                    echo "<option value='{$rap['id']}' {$selected}>{$rap['tenrap']}</option>";
                                }
                                ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>

                <h4 class="title">Thao tác</h4>

                <div class="product-upload-gallery row flex-wrap">


                    <!-- Button Group Start -->
                    <div class="row">
                        <div class="d-flex flex-wrap justify-content-end col mbn-10">
                            <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit" name="them">Thêm</button>
                            <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit"><a href="index.php?act=QTvien" style="color: black;">Danh sách</a></button>
                        </div>
                    </div><!-- Button Group End -->

                </div>
            </div><!-- Add or Edit Product End -->
            <?php if (isset($error) && $error != "") {
                echo '<p  style="color: red; text-align: center;"
                > ' . $error . ' </p>';
            } ?>
        </div>
    </form>
</div><!-- Content Body End -->