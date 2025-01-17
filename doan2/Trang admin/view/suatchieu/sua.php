<?php
include "./view/home/sideheader.php";
if (is_array($loadone_lc)) {
    extract($loadone_lc);
}
?>

<!-- Content Body Start -->
<div class="content-body">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3> Suất Chiếu <span>/ Sửa Suất Chiếu</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <form action="index.php?act=updatelichchieu" method="POST">
        <div class="add-edit-product-wrap col-12">

            <div class="add-edit-product-form">

                <h4 class="title">Sửa Xuất Chiếu</h4>

                <div class="row">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="col-lg-6 col-12 mb-30">
                        <div class="row2 mb10 form_content_container">
                            <select name="id_phim" class="form-control">
                                <?php foreach ($loadphim as $phim) {
                                    extract($phim);
                                    echo '<option value="' . $id . '" ' . ($id == $id_phim ? 'selected' : '') . '>' . $tieu_de . ' - '.$tenrap.' </option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 mb-30">
                        <input class="form-control" type="date" name="nc" value="<?= $ngay_chieu ?>">
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-30">
    <div class="row2 mb10 form_content_container">
        <label>Chọn rạp</label>
        <select name="id_rap" class="form-control">
            <?php foreach ($loadrap as $rap): ?>
                <option value="<?= $rap['id'] ?>" <?= $rap['id'] == $rap_id ? 'selected' : '' ?>>
                    <?= $rap['tenrap'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>


                <h4 class="title">Thao tác</h4>

                <div class="product-upload-gallery row flex-wrap">


                    <!-- Button Group Start -->
                    <div class="row">
                        <div class="d-flex flex-wrap justify-content-end col mbn-10">
                            <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit" name="capnhat">Cập Nhật</button>
                            <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit" ><a href="index.php?act=QLsuatchieu" style="color: black;">Danh sách</a></button>
                        </div>
                    </div><!-- Button Group End -->

                </div>

            </div><!-- Add or Edit Product End -->
            <?php if(isset($error)&&$error !=""){
                echo '<p   style="color: red; text-align: center;"
                > '.$error.' </p>';
            } ?>
        </div>
    </form>
  
</div><!-- Content Body End -->