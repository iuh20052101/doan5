<?php
include "./view/home/sideheader.php";
?>
<!-- Content Body Start -->
<div class="content-body">
<link rel="stylesheet" href="assets/css/stylecolor.css">

    <!-- Page Headings Start -->
    <div class="row justify-content-between align-items-center mb-10">

        <!-- Page Heading Start -->
        <div class="col-12 col-lg-auto mb-20">
            <div class="page-heading">
                <h3> Thêm rạp</span></h3>
            </div>
        </div><!-- Page Heading End -->

        <!-- Page Button Group Start -->

    </div><!-- Page Headings End -->

    <!-- Add or Edit Product Start -->
    <?php if(isset($suatc)&&($suatc)!= ""){
        echo'<p  style="color: red; text-align: center;">' .$suatc. '</p>';
    }?>
    <form action="index.php?act=themrap" method="post"  enctype="multipart/form-data">
        <div class="col-lg-6 col-12 mb-30 ">
            <div class="add-edit-product-form">

                    <h4 class="title">Thêm rạp</h4>

    
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="TÊN RẠP" name="tenrap"></div>
                     

                    </div>
                    <div class="row">
                       
                        <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="ĐỊA CHỈ" name="diachi"></div>
                     

                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="SỐ ĐIỆN THOẠI" name="sdt"></div>
 
                    </div>
                    <div class="row">
                    <div class="col-lg-6 col-12 mb-30"><input class="form-control" type="text" placeholder="EMAIL RẠP" name="email_rap"></div>

                    </div>


                    <h4 class="title">Thao tác</h4>

                    <div class="product-upload-gallery row flex-wrap">


                        <!-- Button Group Start -->
                        <div class="row">
                            <div class="d-flex flex-wrap justify-content-end col mbn-10">
                                <button class="button button-outline button-primary mb-10 ml-10 mr-0" type="submit" name="len">Thêm</button>
                            </div>
                        </div><!-- Button Group End -->

            </div>

        </div><!-- Add or Edit Product End -->

    </form>
    <?php if(isset($error)&&$error !=""){
                echo '<p   style="color: red; text-align: center;"
                > '.$error.' </p>';
            } ?>
</div><!-- Content Body End -->