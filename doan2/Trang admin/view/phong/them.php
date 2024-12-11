<?php
include "./view/home/sideheader.php";
$sql_rap = "SELECT id, tenrap FROM rap";
$rap_list = pdo_query($sql_rap);
?>
<!-- Content Body Start -->
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3>Phòng chiếu <span>/ Thêm phòng</span></h3>
            </div>
        </div>
    </div><!-- Page Headings End -->

    <!-- Thông báo -->
    <?php if(isset($suatc) && ($suatc) != "") {
        echo '<p style="color: red; text-align: center;">' .$suatc. '</p>';
    }?>

    <!-- Form Thêm Phòng -->
    <div class="row">
        <div class="col-12 col-lg-12 mb-30">
            <div class="box">
                <div class="box-head">
                    <h3 class="title">Thêm mới phòng chiếu</h3>
                </div>
                <div class="box-body">
                    <form action="index.php?act=themphong" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-12 mb-30">
                                <div class="form-group">
                                    <label class="label-control">Tên phòng chiếu</label>
                                    <input class="form-control" type="text" name="name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-30">
                                <div class="form-group">
                                    <label class="title">Rạp</label>
                                    <select class="form-control select2" name="rap_id" disabled style="width: 100%;">
                                        <option value="">Chọn rạp</option>
                                        <?php
                                        foreach($rap_list as $rap) {
                                            $selected = ($rap['id'] == $rap_id) ? 'selected' : '';
                                            echo "<option value='{$rap['id']}' {$selected}>{$rap['tenrap']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="rap_id" value="<?= $rap_id ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-30">
                                <div class="form-group">
                                    <label class="label-control">Số hàng</label>
                                    <input class="form-control" type="number" name="so_hang" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-30">
                                <div class="form-group">
                                    <label class="label-control">Số cột (ghế mỗi hàng)</label>
                                    <input class="form-control" type="number" name="so_cot" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12 mb-30">
                                <button class="button button-outline button-primary" type="submit" name="len">
                                    Thêm mới
                                </button>
                                <button class="button button-outline" type="reset">
                                    Nhập lại
                                </button>
                                <a href="index.php?act=phong" class="button button-outline button-info">
                                    Danh sách
                                </a>
                            </div>
                        </div>

                        <?php if(isset($error) && $error != "") {
                            echo '<p style="color: red; text-align: center;">' .$error. '</p>';
                        } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- Content Body End -->