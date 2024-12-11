<?php
session_start();
include "model/pdo.php";
include "model/taikhoan.php";

if (isset($_POST['dangnhap']) && ($_POST['dangnhap'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $user_info = check_tk($user, $pass);

    if ($user_info && ($user_info['vai_tro'] == 1 || $user_info['vai_tro'] == 2 || $user_info['vai_tro'] == 3)) {
        $_SESSION['user1'] = $user_info;
        header('location: index.php');
        exit;
    }

    $loi = "Sai mật khẩu hoặc tên đăng nhập";
}
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.hasthemes.com/adomx-preview/light/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 08 Nov 2023 02:47:53 GMT -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="" type="image" href="assets/img/icon.jpg">

    <!-- CSS
	============================================ -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="assets/css/vendor/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/vendor/themify-icons.css">
    <link rel="stylesheet" href="assets/css/vendor/cryptocurrency-icons.css">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins/plugins.css">

    <!-- Helper CSS -->
    <link rel="stylesheet" href="assets/css/helper.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="assets/css/style-primary.css">
    <style>

    </style>
</head>

<body>
<div class="tong">
    
<div class="main-wrapper">

<!-- Content Body Start -->
<div class="content-body m-0 p-0">

    <div class="login-register-wrap">
        <div class="row">

            <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
                <div class="login-register-form-wrap">

                    <div class="content">
                        <h1>Đăng nhập</h1>
                    </div>

                    <div class="login-register-form">
                        <form action="<?= $_SERVER['PHP_SELF'];  ?>" method="post">
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <input class="form-control" type="text" name="user" placeholder=" Tài khoản đăng nhập"></div>
                                <div class="col-12 mb-20">
                                    <input class="form-control" name="pass" type="password" placeholder="Mật khẩu "></div>
                                <div class="col-12 mb-20">
                                <div class="col-12">
                                    <?php if(isset($loi)&& ($loi)!=""){
                                        echo "<h3 style='color:red'>$loi</h3>";
                                    } ?>
                                </div>
                                <div class="col-12 mt-10">
                                    <input  class="button button-primary button-outline" name="dangnhap" type="submit" value="Đăng Nhập"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div><!-- Content Body End -->

</div>
</div>

<!-- JS
============================================ -->

<!-- Global Vendor, plugins & Activation JS -->
<script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
<script src="assets/js/vendor/jquery-3.3.1.min.js"></script>
<script src="assets/js/vendor/popper.min.js"></script>
<script src="assets/js/vendor/bootstrap.min.js"></script>
<!--Plugins JS-->
<script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="assets/js/plugins/tippy4.min.js.js"></script>
<!--Main JS-->
<script src="assets/js/main.js"></script>

</body>
</html>
<style>
/* Thêm style cho form đăng nhập */
.login-register-form-wrap {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    max-width: 400px;
    width: 100%;

}

.content h1 {
    color: #2196F3;
    font-size: 32px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-control {
    border-radius: 25px;
    padding: 12px 20px;
    border: 2px solid #e0e0e0;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #2196F3;
    box-shadow: 0 0 10px rgba(33, 150, 243, 0.2);
}

.button-primary {
    width: 100%;
    padding: 12px;
    border-radius: 25px;
    background: linear-gradient(45deg, #2196F3, #1976D2);
    border: none;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.button-primary:hover {
    background: linear-gradient(45deg, #1976D2, #2196F3);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
}

/* Style cho background */
body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tong {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 !important;
    padding: 0;
}

.main-wrapper {
    width: 100%;
}

.login-register-wrap .row {
    justify-content: center;
    width: 100%;
    margin: 0;
}

/* Style cho thông báo lỗi */
h3[style*="color:red"] {
    font-size: 14px;
    text-align: center;
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    background-color: rgba(255, 0, 0, 0.1);
}
    </style>