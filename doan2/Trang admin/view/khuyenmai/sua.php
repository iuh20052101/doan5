<?php
include "./view/home/sideheader.php";
if (is_array($loadkhuyenmai1)) {
    extract($loadkhuyenmai1);
}
?>

<!-- Content Body Start -->
<div class="content-body">
    <link rel="stylesheet" href="assets/css/stylecolor.css">


    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3> KHUYẾN MÃI <span>/ SỬA KHUYẾN MÃI</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <form action="index.php?act=updatekhuyenmai" method="POST">
        <div class="col-lg-6 col-12 mb-30">

            <div class="col-lg-6 col-12 mb-30">

                <h4 class="title">SỬA KHUYẾN MÃI</h4>

                <div class="row">
                    <input  type="hidden" name="id" value="<?= $id ?>">

                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Tên khuyến mãi</span><br>
                        <input class="form-control" type="text"  name="ten_km" value="<?=$ten_km?>"></div><br>
               
                </div> 
                <div class="row">
                <input  type="hidden" name="gia_tri" value="<?= $gia_tri ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Giá trị</span><br>
                        <input class="form-control" type="text"  name="gia_tri" value="<?=$gia_tri?>"></div><br>
               
                </div> 
            
            <div class="row">
            <input  type="hidden" name="ngay_ket_thuc" value="<?= $ngay_ket_thuc ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Ngày kết thúc</span><br>
                        <input class="form-control" type="date"  name="ngay_ket_thuc" value="<?=$ngay_ket_thuc?>"></div><br>
               
                </div> 
                <div class="row">
                <input  type="hidden" name="mota" value="<?= $mota ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Mô tả </span><br>
                        <input class="form-control" type="text"  name="mota" value="<?=$mota?>"></div><br>
               
                </div> 

                <h4 class="title">Thao tác</h4>

                <div class="product-upload-gallery row flex-wrap">


                    <!-- Button Group Start -->
                    <div class="row">
                        <div class="d-flex flex-wrap justify-content-end col mbn-10">
                            <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit" name="capnhat">Cập Nhật</button>
                        </div>
                    </div><!-- Button Group End -->

                </div>

            </div><!-- Add or Edit Product End -->

    </form>
    <?php if(isset($error)&&$error !=""){
                echo '<p style="color: red; text-align: center;"
                > '.$error.' </p>';
            } ?>
</div><!-- Content Body End -->