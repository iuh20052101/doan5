<?php
include "./view/home/sideheader.php";
if (is_array($loadrap1)) {
    extract($loadrap1);
}
?>

<!-- Content Body Start -->
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto ">
            <div class="page-heading">
                <h3> RẠP <span>/ SỬA RẠP</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <form action="index.php?act=updaterap" method="POST">
        <div class="col-lg-12 col-12 mb-30">

            <div class="add-edit-product-form">

                <h4 class="title">SỬA RẠP</h4>

                <div class="row">
                    <input  type="hidden" name="id" value="<?= $id ?>">

                    <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Tên rạp</span><br>
                        <input class="form-control" type="text"  name="tenrap" value="<?=$tenrap?>"></div><br>
               
                </div> 
                <div class="row">
                <input  type="hidden" name="diachi" value="<?= $diachi ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Địa chỉ</span><br>
                        <input class="form-control" type="text"  name="diachi" value="<?=$diachi?>"></div><br>
               
                </div> 
            
            <div class="row">
            <input  type="hidden" name="sdt" value="<?= $sdt ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Số điện thoại</span><br>
                        <input class="form-control" type="text"  name="sdt" value="<?=$sdt?>"></div><br>
               
                </div> 
                <div class="row">
                <input  type="hidden" name="email_rap" value="<?= $email_rap ?>">
                <div class="col-lg-6 col-12 mb-30">
                        <span class="title">Email </span><br>
                        <input class="form-control" type="text"  name="email_rap" value="<?=$email_rap?>"></div><br>
               
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