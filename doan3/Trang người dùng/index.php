<?php
ob_start();
session_start();
include "model/pdo.php";
include "model/loai_phim.php";
include "model/phim.php";
include "model/phong.php";
include "model/taikhoan.php";
include "model/lichchieu.php";
include "model/ve.php";
include "model/hoadon.php";
include "model/rap.php"; 
include "model/khuyenmai.php";

date_default_timezone_set("Asia/Ho_Chi_Minh");
$loadloai = loadall_loaiphim();
$loadphim = loadall_phim();
$loadphimhot = loadall_phim_hot();
$loadphimhome = loadall_phim_home();
$loadrap = loadall_rap(); 

include "view/header.php";
if(isset($_GET['act']) && $_GET['act']!=""){
    $act = $_GET['act'];
    switch ($act) {
        case "ctphim":
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $phim = loadone_phim($_GET['id']);
            }
            unset($_SESSION['mv']);
            include "view/ctphim.php";
            break;
            case "dsphim1":
                $dsp = loadall_phim();
                // $dsp=loadall_phim();
                include "view/dsphim1.php";
                break;
        case "dsphim":
            if (isset($_POST['kys']) && $_POST['kys'] != "") {

                $kys = $_POST['kys'];
            } else {
                $kys = "";
            }
            if (isset($_GET['id_loai']) && $_GET['id_loai'] > 0) {
                $id_loai = $_GET['id_loai'];
                $tenloai = load_ten_loai($id_loai);
            } else {
                $id_loai = 0;
            }
            $dsp = loadall_phim1($kys, $id_loai);

            $nameth = phim_select_all();
            // $dsp=loadall_phim();
            include "view/dsphim.php";
            break;
        case "phimsapchieu":
            $psc = load_phimsc();
            include "view/phimsc.php";
            break;
        case "phimdangchieu":
            $pdc = load_phimdc();
            include "view/phimdc.php";
            break;
       
        case "tintuc":
            include "view/tintuc-big.php";
            break;
        case "rapchieu":
            include "view/rapchieu.php";
            break;
            case "dangnhap":
                if (isset($_POST['login'])) {
                    $user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
                    $pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');
                    
                    // Kiểm tra tài khoản
                    $check_tk = check_tk($user);
                    
                    if ($user == '' || $pass == '') {
                        $error = "Vui lòng không để trống";
                        include "view/login/dangnhap.php";
                        break;
                    } else {
                        if (is_array($check_tk) && password_verify($pass, $check_tk['pass'])) {
                            $_SESSION['user'] = $check_tk;
                        } else {
                            $thongbao = "Đăng nhập không thành công. Vui lòng kiểm tra tài khoản của bạn.";
                        }
                    }
                }
                
        include "view/login/dangnhap.php";
                break;
  
                case "dangky":
                    if (isset($_POST['dangky'])) {
                        try {
                            // Validate CSRF token
                            validateCSRFToken($_POST['csrf_token']);
                            
                            $capcha = $_POST['g-recaptcha-response'];
                            $name = htmlspecialchars(strip_tags($_POST['name']));
                            $user = htmlspecialchars(strip_tags($_POST['user']));
                            $pass = $_POST['pass'];
                            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                            $phone = htmlspecialchars(strip_tags($_POST['phone']));
                            $dia_chi = htmlspecialchars(strip_tags($_POST['dia_chi']));

                            $errors = [];

                            // Kiểm tra CAPTCHA
                            if (!$capcha) {
                                $errors[] = "Vui lòng xác minh CAPTCHA";
                            }

                            // Kiểm tra các trường bắt buộc
                            if (empty($name) || empty($user) || empty($pass) || 
                                empty($email) || empty($phone) || empty($dia_chi)) {
                                $errors[] = "Vui lòng điền đầy đủ thông tin.";
                            }

                            // Kiểm tra định dạng email
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $errors[] = "Email không hợp lệ";
                            }

                            // Kiểm tra định dạng số điện thoại Việt Nam
                            if (!preg_match('/^(0[3|5|7|8|9])+([0-9]{8})$/', $phone)) {
                                $errors[] = "Số điện thoại không hợp lệ (phải là số điện thoại Việt Nam)";
                            }

                            // Kiểm tra độ mạnh của mật khẩu
                            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $pass)) {
                                $errors[] = "Mật khẩu phải có ít nhất:\n- 8 ký tự\n- 1 chữ hoa\n- 1 chữ thường\n- 1 số\n- 1 ký tự đặc biệt (@$!%*?&)";
                            }

                            // Kiểm tra tên đăng nhập
                            if (!preg_match('/^[A-Za-z0-9]{4,20}$/', $user)) {
                                $errors[] = "Tên đăng nhập phải từ 4-20 ký tự, chỉ bao gồm chữ cái và số";
                            }

                            // Kiểm tra trùng lặp thông tin
                            $validation_errors = validate_registration($user, $email, $phone);
                            if (!empty($validation_errors)) {
                                $errors = array_merge($errors, $validation_errors);
                            }

                            // Nếu có lỗi
                            if (!empty($errors)) {
                                $thongbao = "Lỗi đăng ký:\n" . implode("\n", $errors);
                                include "view/login/dangky.php";
                                break;
                            }

                            // Nếu không có lỗi, thêm tài khoản mới
                            if (insert_taikhoan($name, $user, $pass, $email, $phone, $dia_chi)) {
                                $_SESSION['registration_success'] = true;
                                header("Location: index.php?act=dangnhap");
                                exit(); // Quan trọng: Phải có exit() sau header
                            } else {
                                $thongbao = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.";
                                include "view/login/dangky.php";
                                break;
                            }

                        } catch (Exception $e) {
                            error_log("Lỗi đăng ký: " . $e->getMessage());
                            $thongbao = "Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.";
                            include "view/login/dangky.php";
                            break;
                        }
                    }
                    include "view/login/dangky.php";
                    break;

                case "quenmk":
                    if (isset($_POST['guiemail'])) {
                        $email = $_POST['email'];
                        if($email == '') {
                            $error = "Vui lòng không để trống";
                        } else {
                            $_SESSION['reset_email'] = $email; // Lưu email để dùng cho bước xác thực
                            $sendMailMess = sendMail($email);
                            if($sendMailMess == "Gửi email thành công") {
                                include "view/login/xacthuc.php"; // Chuyển đến trang xác thực
                                break;
                            }
                        }
                    }
                    include "view/login/quenmk.php";
                    break;



                    case "xacthuc":
                        if(isset($_POST['xacthuc'])) {
                            $verification_code = $_POST['verification_code'];
                            
                            if($verification_code == '') {
                                $error = "Vui lòng nhập mã xác thực";
                            } 
                            else if($verification_code != $_SESSION['verification_code']) {
                                $error = "Mã xác thực không đúng";
                            } 
                            else {
                                // Xác thực thành công, chuyển đến trang đổi mật khẩu mới
                                include "view/login/doimk_quenpass.php";
                                break;
                            }
                        }
                        include "view/login/xacthuc.php";
                        break;

                        case "doimk_quenpass":
                            if(isset($_POST['doimatkhau'])) {
                                $passmoi = $_POST['new_password'];
                                $passmoi1 = $_POST['confirm_password'];
                                $email = $_SESSION['reset_email'];
                                
                                if($passmoi == '' || $passmoi1 == '') {
                                    $error = "Vui lòng không để trống";
                                } 
                                else if($passmoi != $passmoi1) {
                                    $error = "Mật khẩu không khớp";
                                }
                                else if(strlen($passmoi) < 6) {
                                    $error = "Mật khẩu phải có ít nhất 6 ký tự";
                                }
                                else {
                                    // Mã hóa mật khẩu mới
                                    $passmoi_hash = password_hash($passmoi, PASSWORD_DEFAULT);
                                    // Cập nhật mật khẩu mới
                                    doi_mk_email($email, $passmoi_hash);
                                    
                                    // Xóa các session không cần thiết
                                    unset($_SESSION['reset_email']);
                                    unset($_SESSION['verification_code']);
                                    
                                    // Thay vì dùng header, set một biến và điều hướng bằng JavaScript
                                    $_SESSION['success_message'] = "Đổi mật khẩu thành công";
                                    echo "<script>
                                            alert('Đổi mật khẩu thành công!');
                                            window.location.href='index.php?act=dangnhap';
                                          </script>";
                                    exit();
                                }
                            }
                            include "view/login/doimk_quenpass.php";
                            break;

                        




                    
                    case "suatk":
                        if (isset($_GET['idsua'])) {
                            $loadtk = loadone_taikhoan($_GET['idsua']);
                        }
                        include "view/login/sua.php";
                        break;
                        case "updatetk":
                            if (isset($_POST['capnhat']) && $_POST['capnhat'] != "") {
                                $id = $_POST['id'];
                                $user = htmlspecialchars(strip_tags($_POST['user']));
                                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                                $phone = htmlspecialchars(strip_tags($_POST['phone']));
                                $dia_chi = htmlspecialchars(strip_tags($_POST['dia_chi']));

                                $errors = [];

                                // Kiểm tra các trường bắt buộc
                                if (empty($phone) || empty($dia_chi) || empty($user) || empty($email)) {
                                    $errors[] = "Vui lòng điền đầy đủ thông tin.";
                                }

                                // Kiểm tra định dạng email
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $errors[] = "Email không hợp lệ";
                                }

                                // Kiểm tra định dạng số điện thoại Việt Nam
                                if (!preg_match('/^(0[3|5|7|8|9])+([0-9]{8})$/', $phone)) {
                                    $errors[] = "Số điện thoại không hợp lệ (phải là số điện thoại Việt Nam)";
                                }

                                // Kiểm tra tên đăng nhập
                                if (!preg_match('/^[A-Za-z0-9_]+$/', $user)) {
                                    $errors[] = "Tên người dùng không hợp lệ. Tên người dùng không được chứa khoảng trắng và dấu.";
                                }

                                // Kiểm tra trùng lặp
                                $validation_errors = validate_update($user, $email, $phone, $id);
                                if (!empty($validation_errors)) {
                                    $errors = array_merge($errors, $validation_errors);
                                }

                                // Nếu có lỗi
                                if (!empty($errors)) {
                                    $thongbao = "Lỗi cập nhật:\n" . implode("\n", $errors);
                                } else {
                                    // Nếu không có lỗi, cập nhật thông tin
                                    sua_tk($id, $user, $email, $phone, $dia_chi);
                                    $thongbao = "Cập nhật thành công";
                                }
                            }
                            
                            // Load lại thông tin tài khoản sau khi cập nhật
                            $loadtk = loadone_taikhoan($id);
                            include "view/login/sua.php";
                            break;

                        
                            case "datve":
                                if (isset($_GET['id']) && $_GET['id'] > 0) {
                                    try {
                                        // Set timezone và lấy thời gian hiện tại
                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                        $current_datetime = date('Y-m-d H:i:s');
                                        
                                        $id_phim = $_GET['id'];
                                        $phim = loadone_phim($id_phim);
                                        
                                        // Cập nhật danh sách rạp với tọa độ chính xác
                                        $loadrap = [
                                            [
                                                'id' => 1,
                                                'tenrap' => "TIAM Quang Trung",
                                                'lat' => 10.8272384,
                                                'lng' => 106.6771907,
                                                'dia_chi' => "60 Quang Trung, Phường 10, Gò Vấp, Hồ Chí Minh"
                                            ],
                                            [
                                                'id' => 2,
                                                'tenrap' => "TIAM Tân Bình",
                                                'lat' => 10.7904435,
                                                'lng' => 106.6522673,
                                                'dia_chi' => "667, Lý Thường Kiệt, Phường 11, Tân Bình, Hồ Chí Minh"
                                            ],
                                            [
                                                'id' => 3,
                                                'tenrap' => "TIAM Bình Thạnh",
                                                'lat' => 10.8175564,
                                                'lng' => 106.7229686,
                                                'dia_chi' => "44 Bình Quới, Phường 27, Quận Bình Thạnh, Hồ Chí Minh"
                                            ],
                                            [
                                                'id' => 4,
                                                'tenrap' => "TIAM Bình Tân",
                                                'lat' => 10.7463723,
                                                'lng' => 106.6208889,
                                                'dia_chi' => " 39 Đường Dương Tự Quán, An Lạc A, Bình Tân, Hồ Chí Minh"
                                            ],
                                            [
                                                'id' => 5,
                                                'tenrap' => "TIAM Quận 1",
                                                'lat' => 10.774971,
                                                'lng' => 106.703991,
                                                'dia_chi' => "103 Đồng Khởi, Phường Bến Nghé, Quận 1, Hồ Chí Minh"
                                            ]
                                        ];
                                        
                                        // Lấy lịch chiếu theo rạp hoặc tổng thể
                                        if (isset($_GET['rap_id']) && $_GET['rap_id'] > 0) {
                                            $rap_id = $_GET['rap_id'];
                                            $lc = loadall_lichchieu_by_rap($id_phim, $rap_id);
                                        } else {
                                            $lc = loadall_lichchieu_user($id_phim);
                                        }
                                        
                                        // Lọc lịch chiếu ã qua
                                        $lc = array_filter($lc, function($item) use ($current_datetime) {
                                            return $item['ngay_chieu'] >= date('Y-m-d');
                                        });
                                        
                                        // Lấy khung giờ nếu có id_lc
                                        if (isset($_GET['id_lc'])) {
                                            $id_lc = $_GET['id_lc'];
                                            $khunggio = get_khung_gio_by_lichchieu($id_lc);
                                            
                                            // Lọc khung giờ đã qua
                                            $khunggio = array_filter($khunggio, function($item) use ($current_datetime) {
                                                $show_datetime = $item['ngay_chieu'] . ' ' . $item['thoi_gian_chieu'];
                                                return $show_datetime > $current_datetime;
                                            });
                                        } else {
                                            $khunggio = array();
                                        }
                                        
                                        // Debug
                                        error_log("Số lịch chiếu còn lại: " . count($lc));
                                        error_log("Số khung giờ còn lại: " . count($khunggio));
                                        
                                    } catch(Exception $e) {
                                        error_log("Lỗi trong case datve: " . $e->getMessage());
                                        $lc = array();
                                        $khunggio = array();
                                    }
                                }
                                include "view/dv.php";
                                break;



                          
                                case "datve2":
                                    if(!isset($_SESSION['user'])) {
                                        $thongbao['dangnhap'] = 'Vui lòng đăng nhập để đặt vé!';
                                        include 'view/login/dangnhap.php';
                                        break;
                                    }
    
                                    // Kiểm tra nếu có thay đổi thông tin đặt vé
                                    $id_phim = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                                    $id_lichchieu = isset($_GET['id_lc']) ? (int)$_GET['id_lc'] : 0;
                                    $id_g = isset($_GET['id_g']) ? (int)$_GET['id_g'] : 0;
                                    $id_phong = isset($_GET['id_phong']) ? (int)$_GET['id_phong'] : 0;
    
                                    // Nếu có thay đổi thông tin hoặc chưa có session
                                    if($id_phim && $id_lichchieu && $id_g && $id_phong) {
                                        // Reset session khi thay đổi phòng
                                        if(!isset($_SESSION['mv']) || $_SESSION['mv'][3] != $id_phong) {
                                            unset($_SESSION['mv']);
                                            unset($_SESSION['tong']);
                                        }
    
                                        // Lấy thông tin lịch chiếu mới
                                        $list_lc = load_lc_p($id_phim, $id_lichchieu, $id_g);
                                        
                                        if($list_lc) {
                                            $_SESSION['mv'] = [
                                                0 => $id_phim,
                                                1 => $id_lichchieu, 
                                                2 => $id_g,
                                                3 => $id_phong
                                            ];
                                            
                                            $_SESSION['phim_info'] = loadone_phim($id_phim);
                                            $_SESSION['tong'] = $list_lc;
                                            $_SESSION['tong']['id_g'] = $id_g;
                                            $_SESSION['tong']['id_phongchieu'] = $id_phong;
                                            $_SESSION['tong']['id_phong'] = $id_phong;
                                            
                                            // Ly thông tin phòng và rạp
                                            $phong_info = lay_thong_tin_phong($id_phong);
                                            if($phong_info) {
                                                $_SESSION['tong']['rap_id'] = $phong_info['rap_id'];
                                            }
                                        }
                                    }
    
                                    include "view/dv2.php";
                                    break;
      
                                case 'save_price':
                                    header('Content-Type: application/json');
                                    $data = json_decode(file_get_contents('php://input'), true);
                                    
                                    $_SESSION['tong']['original_price'] = $data['original_price'];
                                    $_SESSION['tong']['discount_amount'] = $data['discount_amount'];
                                    $_SESSION['tong']['final_price'] = $data['final_price'];
                                    $_SESSION['tong']['promotion_id'] = $data['promotion_id'];
                                    
                                    echo json_encode(['success' => true]);
                                    exit;


                                
                                case "dv3":
                                    if(!isset($_SESSION['user'])) {
                                        $thongbao['dangnhap'] = 'Vui lòng đăng nhập để đặt vé!';
                                        include 'view/login/dangnhap.php';
                                        break;
                                    }

                                    try {
                                        // Kiểm tra và lưu thông tin từ form POST
                                        if(isset($_POST['tiep_tuc'])) {
                                            // Debug
                                            error_log("Received POST data in dv3: " . print_r($_POST, true));
                                            
                                            // Lưu thông tin ghế dưới dạng mảng
                                            if(isset($_POST['ten_ghe'])) {
                                                // Nếu là chuỗi thì chuyển thành mảng
                                                if(is_string($_POST['ten_ghe'])) {
                                                    $_SESSION['tong']['ten_ghe'] = explode(',', $_POST['ten_ghe']);
                                                } else {
                                                    $_SESSION['tong']['ten_ghe'] = $_POST['ten_ghe'];
                                                }
                                            }

                                            // Lưu ID ghế dưới dạng mảng
                                            if(isset($_POST['ghe_id'])) {
                                                if(is_string($_POST['ghe_id'])) {
                                                    $_SESSION['tong']['ghe_id'] = explode(',', $_POST['ghe_id']);
                                                } else {
                                                    $_SESSION['tong']['ghe_id'] = $_POST['ghe_id'];
                                                }
                                            }
                                            
                                            // Lưu thông tin giá và tổng tiền
                                            $_SESSION['tong']['gia_ghe'] = isset($_POST['giaghe']) ? (int)$_POST['giaghe'] : 0;
                                            $_SESSION['tong']['tong_tien'] = isset($_POST['tong_tien_ghe']) ? (int)$_POST['tong_tien_ghe'] : 0;
                                            
                                            // Lưu thông tin khuyến mãi
                                            if(isset($_POST['promotion_id']) && !empty($_POST['promotion_id'])) {
                                                $_SESSION['tong']['promotion_id'] = $_POST['promotion_id'];
                                                $_SESSION['tong']['discount_amount'] = $_POST['discount_amount'];
                                                $_SESSION['tong']['final_price'] = $_POST['final_price_input'];
                                            }
                                            
                                            // Lưu thông tin rạp
                                            if(isset($_POST['id_rap']) && isset($_POST['ten_rap'])) {
                                                $_SESSION['tong']['id_rap'] = $_POST['id_rap'];
                                                $_SESSION['tong']['tenrap'] = $_POST['ten_rap'];
                                                $_SESSION['tong']['dia_chi_rap'] = $_POST['dia_chi_rap'] ?? '';
                                            }
                                            
                                            // Debug
                                            error_log("Đã lưu thông tin vé trong session: " . print_r($_SESSION['tong'], true));
                                        }
                                        
                                        include "view/doan.php";
                                        
                                    } catch (Exception $e) {
                                        error_log("Error in dv3: " . $e->getMessage());
                                        header("Location: index.php?act=datve2&id=".$_SESSION['tong']['id_phim']);
                                        exit();
                                    }
                                    break;

                                    // case 'save_total':
                                    //     if(isset($_POST['tong_cong'])) {
                                    //         $_SESSION['tong']['gia_ghe'] = $_POST['gia_ghe'];
                                            
                                    //         // Chỉ lưu tiền đồ ăn và cập nhật tổng tiền nếu có đồ ăn được chọn
                                    //         if(isset($_POST['co_do_an']) && $_POST['co_do_an'] === true) {
                                    //             $_SESSION['tong']['tien_do_an'] = $_POST['tien_do_an'];
                                    //             $_SESSION['tong']['tong_cong'] = $_POST['tong_cong'];
                                    //         } else {
                                    //             // Nếu không có đồ ăn, tổng tiền = giá ghế từ dv2
                                    //             $_SESSION['tong']['tien_do_an'] = 0;
                                    //             $_SESSION['tong']['tong_cong'] = $_POST['gia_ghe'];
                                    //         }
                                            
                                    //         // Cập nhật tong_tien_thanh_toan để sử dụng cho hóa đơn
                                    //         $_SESSION['tong']['tong_tien_thanh_toan'] = $_SESSION['tong']['tong_cong'];
                                            
                                    //         // Debug
                                    //         error_log("Đã cập nhật tổng tiền: " . $_SESSION['tong']['tong_tien_thanh_toan']);
                                            
                                    //         echo json_encode(['success' => true]);
                                    //     }
                                    //     exit;
                                    //     break;
                                        

                                    case "dv4":
                                        if (isset($_POST['tiep_tuc']) && ($_POST['tiep_tuc'])) {
                                            // Lấy thông tin từ form POST
                                            $gia_ghe = isset($_POST['giaghe']) ? (int)$_POST['giaghe'] : 0;
                                            
                                            // Lấy thông tin ghế từ session và chuyển thành chuỗi
                                            $ghe = isset($_SESSION['tong']['ten_ghe']) ? implode(', ', $_SESSION['tong']['ten_ghe']) : '';
                                            
                                            // Debug
                                            error_log("Tên ghế đã chọn: " . $ghe);
                                            
                                            // Lưu vào session
                                            $_SESSION['tong']['ghe'] = $ghe; // Lưu chuỗi tên ghế 'G3, G4'
                                            $_SESSION['tong']['gia_ghe'] = $gia_ghe;
                                            
                                            // Lưu thông tin đồ ăn từ form
                                            $ten_doan = array();
                                            if(isset($_POST['ten_do_an'])) {
                                                $ten_doan['doan'] = $_POST['ten_do_an'];
                                            }
                                            
                                            // Lưu vào session
                                            $_SESSION['tong']['gia_ghe'] = $gia_ghe;  // Giá ghế đã bao gồm cả tiền đồ ăn
                                            $_SESSION['tong']['ghe'] = $ghe;
                                            $_SESSION['tong']['tien_do_an'] = $tien_do_an;
                                            $_SESSION['tong']['combo'] = (isset($ten_doan['doan']) && !empty($ten_doan['doan'])) ? implode(', ', $ten_doan['doan']) : null;
                                            
                                            // Lưu tổng tiền vào session - sử dụng giá ghế trực tiếp vì đã bao gồm tất cả
                                            $_SESSION['tong']['tong_tien_thanh_toan'] = $gia_ghe;
                                            
                                            // Debug session sau khi lưu
                                            error_log("Session sau khi lưu trong dv4: " . print_r($_SESSION['tong'], true));
                                            error_log("Tổng tiền cuối cùng: " . $_SESSION['tong']['tong_tien_thanh_toan']);
                                            
                                            include 'view/thanhtoan.php';
                                        } else {
                                            include 'view/thanhtoan.php';
                                        }
                                        break;


                                        

                                        case "bill":
                                            if (!isset($_SESSION['tong']) || !isset($_SESSION['user'])) {
                                                echo "<script>
                                                    alert('Phiên làm việc đã hết hạn, vui lòng đặt vé lại!');
                                                    window.location.href='index.php';
                                                </script>";
                                                exit;
                                            }
                                        
                                            $payment_success = false;

                                            // Kiểm tra response từ MOMO hoặc ZaloPay
                                            if ((isset($_GET['resultCode']) && $_GET['resultCode'] == '0') || 
                                                (isset($_GET['status']) && $_GET['status'] == 1)) {
                                                $payment_success = true;
                                            }

                                            if ($payment_success) {
                                                // Lấy thông tin từ session
                                                $tong_tien = $_SESSION['tong']['tong_tien_thanh_toan'];
                                                $ghe = $_SESSION['tong']['ghe']; 
                                                $id_user = $_SESSION['user']['id'];
                                                $id_kgc = $_SESSION['tong']['id_g'];
                                                $id_lc = $_SESSION['tong']['id_lichchieu'];
                                                $id_phim = $_SESSION['tong']['id_phim'];
                                                $combo = isset($_SESSION['tong']['combo']) ? $_SESSION['tong']['combo'] : null;

                                                // Xử lý thanh toán thành công
                                                $result = process_payment_success(
                                                    $tong_tien, 
                                                    $ghe, 
                                                    $id_user, 
                                                    $id_kgc, 
                                                    $id_lc, 
                                                    $id_phim, 
                                                    $combo
                                                );

                                                if ($result['success']) {
                                                    // Lưu ID vé vào session để gửi mail sau
                                                    $_SESSION['pending_email_ve_id'] = $result['id_ve'];
                                                    
                                                    // Xóa session đặt vé
                                                    unset($_SESSION['tong']);
                                                    
                                                    // Chuyển hướng đến trang vé
                                                    echo "<script>
                                                        window.location.href='index.php?act=ve&id=" . $result['id_ve'] . "';
                                                    </script>";
                                                    exit;
                                                } else {
                                                    echo "<script>
                                                        alert('Có lỗi xảy ra: " . addslashes($result['message']) . "');
                                                        window.location.href='index.php?act=thanhtoan';
                                                    </script>";
                                                }
                                            } else {
                                                // Thanh toán thất bại
                                                echo "<script>
                                                    alert('Thanh toán không thành công!');
                                                    window.location.href='index.php?act=thanhtoan';
                                                </script>";
                                            }
                                            break;
                                      
                                      
                                    case  "thanhtoan" :
                                        include "view/thanhtoan.php";
                                        break;

                                        
                                         case "ve":
            if(isset($_GET['id'])) {
                // Xem chi tiết một vé
                $id_ve = $_GET['id'];
                $load_ve_tt = load_ve_thanhtoan($id_ve);
                if($load_ve_tt) {
                    include "view/ve_tt.php";
                } else {
                    $_SESSION['error'] = "Không tìm thấy thông tin vé!";
                    header("Location: index.php?act=ve");
                }
            } else {
                // Xem danh sách vé
                if(isset($_SESSION['user'])){
                    $load_ve = load_ve($_SESSION['user']['id']);
                }
                include "view/ve.php";
            }
            break;

        case "ve_thanhtoan":
            if(isset($_GET['id'])) {
                $id_ve = $_GET['id'];
                $load_ve_tt = load_ve_thanhtoan($id_ve);
                include "view/ve_tt.php";
            } else {
                header("Location: index.php?act=ve");
            }
            break;

        case 'xacnhan':
            if (isset($_GET['message']) && ($_GET['message'] == 'Successful.')) {
                trangthai_hd($_SESSION['id_hd']);
                trangthai_ve($_SESSION['id_hd']);
                $load_ve_tt =  load_ve_tt($_SESSION['id_hd']);
                gui_mail_ve($load_ve_tt);
                require_once "view/ve_tt.php";
                break;
            }
        case "ctve":
            if (isset($_GET['id']) && ($_GET['id'] > 0)){
                $loadone_ve =  loadone_vephim($_GET['id']);
            }
            include "view/chitiet_ve.php";
            break;

        case "huy_ve":
            if(isset($_POST['capnhat'])){
                $id = $_POST['id'];
                huy_vephim($id);
            }
            // Sử dụng $_POST['id'] thay vì $_GET['id']
            $loadone_ve =  loadone_vephim($_POST['id']);
            include "view/chitiet_ve.php";
            break;



            case "dangxuat":
                dang_xuat();
                include "view/login/dangnhap.php";
                break;






           case "doimk":
    if (isset($_POST['capnhat']) && $_POST['capnhat'] != "") {
        $id = $_POST['id'];
        $pass = $_POST['pass'];
        $passmoi = $_POST['passmoi'];
        $passmoi1 = $_POST['passmoi1'];
        
        // Lấy mật khẩu cũ từ cơ sở dữ liệu
        $old_pass = mkcu($id);
        
        // Kiểm tra mật khẩu cũ
        if (!password_verify($pass, $old_pass)) {
            $error = "Mật khẩu cũ không đúng";
        }
        
        // Kiểm tra mật khẩu mới có trùng mật khẩu cũ không
        if (password_verify($passmoi, $old_pass)) {
            $error = "Mật khẩu mới không được trùng với mật khẩu cũ";
        }
        
        // Kiểm tra mật khẩu mới có trùng nhau không
        if ($passmoi != $passmoi1) {
            $error = "Mật khẩu mới không trùng nhau";
        }
        
        if (!isset($error)) {
            // Mã hóa mật khẩu mới
            $passmoi_hash = password_hash($passmoi, PASSWORD_DEFAULT);
            doi_tk($id, $passmoi_hash);
            $error = "Đổi mật khẩu thành công";
            include "view/login/doimk.php";  
        } else {
            // Hiển thị lỗi ra view
            include "view/login/doimk.php"; 
        }
    } else {
        include "view/login/doimk.php";
    }
    
    break;



     


       




    case "theloai":
        if (isset($_GET['id_loai']) && $_GET['id_loai'] > 0) {
            $id_loai = $_GET['id_loai'];
            $dsp = get_phim_by_loai($id_loai); // Lấy danh sách phim theo loại
            $ten_loai = load_ten_loai($id_loai); // Lấy tên thể loại
        } else {
            $dsp = loadall_phim(); // Load tất cả phim nếu không có id_loai
            $ten_loai = "Tất cả phim";
        }
        include "view/theloaiphim.php";
        break;
     

      
        case 'lienhe':
            if(isset($_POST['guimail'])) {
                // Kiểm tra dữ liệu trống
                if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
                    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin";
                    header("Location: index.php?act=lienhe");
                    exit;
                }
        
                // Kiểm tra email hợp lệ
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = "Email không hợp lệ";
                    header("Location: index.php?act=lienhe");
                    exit;
                }
        
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);
                
                require_once "model/sendmail.php";
                
                try {
                    $result = sendEmail($name, $email, $message);
                    if($result === true) {
                        $_SESSION['message'] = "Gửi mail thành công! Vui lòng kiểm tra hộp thư.";
                    } else {
                        $_SESSION['error'] = $result;
                    }
                } catch(Exception $e) {
                    error_log("Lỗi gửi mail: " . $e->getMessage()); // Ghi log lỗi
                    $_SESSION['error'] = "Có lỗi xảy ra khi gửi mail. Vui lòng thử lại sau.";
                }
                
                header("Location: index.php?act=lienhe");
                exit;
            }
            include "view/lienhe.php";
            break;

                case 'get_showtimes':
                    if(isset($_GET['rap_id']) && isset($_GET['id_phim'])) {
                        $rap_id = $_GET['rap_id'];
                        $id_phim = $_GET['id_phim'];
                        
                        try {
                            $dates = loadall_lichchieu_by_rap($rap_id, $id_phim);
                            $times = [];
                            
                            if(!empty($dates)) {
                                $times = get_khung_gio_by_lichchieu($dates[0]['id']);
                            }
                            
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode([
                                'status' => 'success',
                                'dates' => $dates,
                                'times' => $times
                            ], JSON_UNESCAPED_UNICODE);
                            
                        } catch(Exception $e) {
                            header('Content-Type: application/json; charset=utf-8');
                            echo json_encode([
                                'status' => 'error',
                                'message' => $e->getMessage()
                            ], JSON_UNESCAPED_UNICODE);
                        }
                        exit();
                    }
                    break;
                      



                    case 'doi_diem':
                        // Đảm bảo không có output nào trước khi gửi JSON
                        ob_clean(); // Xóa bất k output buffer nào
                        header('Content-Type: application/json');
                        
                        if (!isset($_SESSION['user'])) {
                            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập']);
                            exit;
                        }
                        
                        $data = json_decode(file_get_contents('php://input'), true);
                        
                        if (!isset($data['id_km'])) {
                            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin khuyến mãi']);
                            exit;
                        }
                        
                        $result = process_promotion_exchange($_SESSION['user']['id'], $data['id_km']);
                        
                        if ($result['success']) {
                            $_SESSION['user']['diem_tich_luy'] = $result['points'];
                        }
                        
                        echo json_encode($result);
                        exit;



    }
}else{
    unset($_SESSION['id_hd']);
    unset($_SESSION['id_ve']);
    unset($_SESSION['mv']);
    unset($_SESSION['tong']);
    include "view/home.php";
}
include "view/footer.php";



?>

