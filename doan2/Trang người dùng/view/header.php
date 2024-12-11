<!doctype html>
<html>

<head>
    <!-- Basic Page Needs -->
    <meta charset="utf-8">
    <title>TIAMS</title>
    <meta name="description" content="A Template by Gozha.net">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Gozha.net">

    <!-- Mobile Specific Metas-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="telephone=no" name="format-detection">
    <link rel="shortcut icon" type="image/x-icon" href="../images/movie-img1.jpg">

    <!-- Fonts -->
    <!-- Font awesome - icon font -->
    <link href="netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <!-- Roboto -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,700' rel='stylesheet' type='text/css'> -->
    <!-- Open Sans -->
    <!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:800italic' rel='stylesheet' type='text/css'> -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="login-ui2/login-ui2/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" />
    <!-- Mobile menu -->
    <link href="css/gozha-nav.css" rel="stylesheet" />
    <!-- Select -->
    <link href="css/external/jquery.selectbox.css" rel="stylesheet" />

    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="rs-plugin/css/settings.css" media="screen" />

    <!-- Custom -->
    <link href="css/style3860.css?v=1" rel="stylesheet" />
    <link rel="stylesheet" href="css/dv.css">
    <!-- Modernizr -->
    <script src="js/external/modernizr.custom.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js"></script>
    <script src="js/custom.js"></script>
    <![endif]-->
</head>

<body>
<div class="wrapper">

    <!-- Header section -->
    <header class="header-wrapper header-wrapper--home header-modern">
        <div class="container">
            <!-- Logo link-->
            <a href='index.php' class="logo logo-modern">
                <img alt='logo' src="imgavt/logo.png">
            </a>

            <!-- Main website navigation-->
            <nav id="navigation-box" class="nav-modern">
                <!-- Toggle for mobile menu mode -->
                <a href="#" id="navigation-toggle">
                        <span class="menu-icon">
                            <span class="icon-toggle" role="button" aria-label="Toggle Navigation">
                              <span class="lines"></span>
                            </span>
                        </span>
                </a>
                <ul id="navigation">
                    <li>
                        <span class="sub-nav-toggle plus"></span>
                        <a href="index.php">Trang chủ</a>

                    </li>
              
                    <li>
                        <span class="sub-nav-toggle plus"></span>
                        <a href="index.php?act=dsphim">Phim</a>
                      
                    </li>

                    <li>
                        <span class="sub-nav-toggle plus"></span>
                        <a href="">Thể loại</a>
                        <ul>
                            <?php foreach ($loadloai as $loaip){
                                extract($loaip);
                                $linkloaip = 'index.php?act=theloai&id_loai='.$id;
                                echo '<li class="menu__nav-item"><a href="'.$linkloaip.'" >'.$name.'</a></li>';
                            } ?>

                        </ul>
                    </li>
                    <li>
                        <span class="sub-nav-toggle plus"></span>
                        <a href="index.php?act=lienhe">Liên hệ</a>

                    </li>
                    <li>
                        <span class="sub-nav-toggle plus"></span>
                        <a href="index.php?act=tintuc">Tin tức</a>

                    </li>
                </ul>
            </nav>
            <div class="control-panel control-panel-modern">
                           <?php if (isset($_SESSION['user'])){
                                  extract($_SESSION['user']);
                                  echo '<a href="index.php?act=dangnhap" class="btn btn-md btn--warning btn--book btn-modern">'.$name.'</a>';
                                  }else{
                               echo '<a href="index.php?act=dangnhap" class="btn btn-md btn--warning btn--book btn-modern">Đăng nhập</a>';
                                  }?>

            </div>

        </div>
    </header>

    <!-- Header scroll effect -->
    <script>
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.header-wrapper');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    </script>




<style>
  /* Modern Header Styling */
.header-modern {
    background: rgba(0, 0, 0, 0.8) !important;
    backdrop-filter: blur(10px) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
    padding: 15px 0 !important;
    height: 80px !important;
}

/* Navigation container */
.nav-modern {
    float: right !important;
    height: 50px !important;
    display: flex !important;
    align-items: center !important;
}

/* Navigation items */
.nav-modern #navigation {
    display: flex !important;
    align-items: center !important;
    margin: 0 !important;
    padding: 0 !important;
    height: 100% !important;
}

.nav-modern #navigation > li {
    margin: 0 15px !important;
    padding: 0 !important;
    height: 100% !important;
    display: flex !important;
    align-items: center !important;
}

.nav-modern #navigation > li > a {
    color: #fff !important;
    font-size: 15px !important;
    font-weight: 500 !important;
    padding: 0 5px !important;
    position: relative !important;
    transition: color 0.3s ease !important;
    line-height: 50px !important;
    display: flex !important;
    align-items: center !important;
}

.nav-modern #navigation > li > a:after {
    content: '' !important;
    position: absolute !important;
    bottom: 0 !important;
    left: 0 !important;
    width: 0 !important;
    height: 2px !important;
    background: linear-gradient(45deg, #00dbde, #fc00ff) !important;
    transition: width 0.3s ease !important;
}

.nav-modern #navigation > li:hover > a:after {
    width: 100% !important;
}

/* Dropdown */
.nav-modern #navigation ul {
    background: rgba(0, 0, 0, 0.95) !important;
    border-radius: 10px !important;
    padding: 10px 0 !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    min-width: 200px !important;
}

.nav-modern #navigation ul li a {
    padding: 8px 20px !important;
    color: #fff !important;
    transition: all 0.3s ease !important;
}

.nav-modern #navigation ul li a:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    padding-left: 25px !important;
}

/* Login Button */
.btn-modern {
    background: linear-gradient(45deg, #00dbde, #fc00ff) !important;
    border: none !important;
    padding: 10px 25px !important;
    border-radius: 25px !important;
    color: #fff !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
    height: 40px !important;
    line-height: 40px !important;
    display: flex !important;
    align-items: center !important;
}

.btn-modern:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.3) !important;
}

/* Control Panel */
.control-panel-modern {
    margin-left: 20px !important;
    display: flex !important;
    align-items: center !important;
    height: 50px !important;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-modern #navigation {
        flex-direction: column !important;
    }
    
    .nav-modern #navigation > li {
        margin: 5px 0 !important;
        width: 100% !important;
    }
    
    .nav-modern #navigation ul {
        position: static !important;
        width: 100% !important;
    }
}

/* Logo adjustment */
.logo-modern {
    display: flex !important;
    align-items: center !important;
    height: 40px !important;
}

.logo-modern img {
    height: 65px !important;
    width: auto !important;
    transition: transform 0.3s ease !important;
}

.logo-modern:hover img {
    transform: scale(1.05) !important;
}
</style>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ9_Mr6bwOftOJJMSs5Uwmg7omcqT8MiM&libraries=geometry"></script>