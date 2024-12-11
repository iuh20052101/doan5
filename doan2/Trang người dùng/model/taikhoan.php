<?php
function loadall_taikhoan(){
    $sql = "select * from taikhoan where 1 order by id asc";
    $re = pdo_query($sql);
    return $re;
}

function check_tk($user) {
    // Lấy thông tin tài khoản từ cơ sở dữ liệu
    $sql = "select * from taikhoan where user = ?";
    $result = pdo_query_one($sql, $user);

    return $result;
}
function dang_xuat(){
    unset($_SESSION['user']);
}

// function insert_taikhoan($email,$user,$pass,$name,$sdt,$dc){
//     $sql="INSERT INTO `taikhoan` ( `email`, `user`, `pass`,`dia_chi`,`phone`,`name`) VALUES ( '$email', '$user','$pass','$dc','$sdt','$name'); ";
//     pdo_execute($sql);
// }

function sua_tk($id,$user,$email,$sdt,$dc){
    $sql = "update taikhoan set  user ='".$user."',email ='".$email."',phone ='".$sdt."',dia_chi ='".$dc."' where id=".$id;

    pdo_execute($sql);
}
function mkcu($id){
    $sql = "select pass from taikhoan where id = $id"; 
    $result = pdo_query_one($sql);
    return $result['pass']; 
}
function doi_tk($id,$passmoi){
    $sql = "UPDATE taikhoan SET pass ='".$passmoi."' WHERE id=".$id;

    pdo_execute($sql);
}
function loadone_taikhoan($id){
    $sql = "select * from taikhoan where id =".$id;
    $result = pdo_query_one($sql);
    return $result;
}

function sendMail($email) {
    // Truy vấn cơ sở dữ liệu để tìm kiếm tài khoản có địa chỉ email $email
    $sql="SELECT * FROM taikhoan WHERE email='$email'";
    $taikhoan = pdo_query_one($sql);

    // Nếu tài khoản được tìm thấy, gửi email cho người dùng
    if ($taikhoan != false) {
        sendMailPass($email, $taikhoan['name'], $taikhoan['pass']);

        return "Gửi email thành công";
    } else {
        // Nếu tài khoản không được tìm thấy, trả về thông báo lỗi
        return "Email bạn nhập không có trong hệ thống";
    }
}

function sendMailPass($email, $name) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $verification_code = rand(100000, 999999); // Tạo mã xác thực ngẫu nhiên
    $_SESSION['verification_code'] = $verification_code;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'haibang741@gmail.com';                     //SMTP username
        $mail->Password   = 'wiud ljdp mkkh zzuz';                               //SMTP password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('haibang741@gmail.comm', 'TIAMS');
        $mail->addAddress($email, $name);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'User verification code';
        $mail->Body    = 'Mã xác thực của bạn là: ' .$_SESSION['verification_code'];

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function check_email($email)
{
    $sql = "SELECT email FROM taikhoan WHERE email ='" . $email . "'";
    $user = pdo_query_one($sql);
    return $user;
}

function doi_mk_email($email, $passmoi){
    $sql = "UPDATE taikhoan SET pass = ? WHERE email = ?";
    pdo_execute($sql, $passmoi, $email);
}
function doi_diem_khuyen_mai($user_id, $id_km, $gia_tri) {
    try {
        // Trừ điểm của user
        $sql = "UPDATE taikhoan SET diem = diem - ? WHERE id = ?";
        pdo_execute($sql, $gia_tri, $user_id);
        
        // Lưu lịch sử đổi điểm
        $sql = "INSERT INTO lich_su_doi_diem (id_user, id_khuyen_mai, diem_doi, ngay_doi) 
                VALUES (?, ?, ?, NOW())";
        pdo_execute($sql, $user_id, $id_km, $gia_tri);
        
        return true;
    } catch(PDOException $e) {
        return false;
    }
}
function checkuser($user,$pass) {
    // Thêm dấu ? để tránh SQL injection
    $sql = "SELECT * FROM taikhoan WHERE user = ? AND pass = ?";
    $sp = pdo_query_one($sql, $user, $pass);
    
    if($sp){
        // Debug để xem dữ liệu
        echo "Dữ liệu từ DB:";
        var_dump($sp);
        
        $_SESSION['user'] = [
            'id' => $sp['id'],
            'name' => $sp['name'],
            'user' => $sp['user'],
            'pass' => $sp['pass'],
            'email' => $sp['email'],
            'dia_chi' => $sp['dia_chi'],
            'phone' => $sp['phone'],
            'vai_tro' => $sp['vai_tro'],
            'diem_tich_luy' => intval($sp['diem_tich_luy']) // Chuyển đổi sang số nguyên
        ];
        
        // Debug để xem session
        echo "Dữ liệu trong session:";
        var_dump($_SESSION['user']);
        
        return $sp;
    }else{
        return false;
    }
}

// Thêm function để kiểm tra điểm trực tiếp
function get_diem_tich_luy($user_id) {
    try {
        $sql = "SELECT diem_tich_luy FROM taikhoan WHERE id = ?";
        // Truyền tham số dưới dạng mảng
        $result = pdo_query_one($sql, [$user_id]);
        return $result ? $result['diem_tich_luy'] : 0;
    } catch(Exception $e) {
        error_log("Lỗi lấy điểm tích lũy: " . $e->getMessage());
        return 0;
    }
}

// Thêm các hàm bảo mật
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

function insert_taikhoan($name, $user, $pass, $email, $phone, $dia_chi) {
    try {
        // Sanitize input
        $name = htmlspecialchars(strip_tags($name));
        $user = htmlspecialchars(strip_tags($user));
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars(strip_tags($phone));
        $dia_chi = htmlspecialchars(strip_tags($dia_chi));
        
        // Hash password
        $hashed_password = hashPassword($pass);
        
        // Debug log
        error_log("Attempting to insert user with data: " . json_encode([
            'name' => $name,
            'user' => $user,
            'email' => $email,
            'phone' => $phone,
            'dia_chi' => $dia_chi
        ]));
        
        $sql = "INSERT INTO taikhoan(name, user, pass, email, phone, dia_chi) 
                VALUES (?, ?, ?, ?, ?, ?)";
                
        // Thực thi với PDO
        $result = pdo_execute($sql, $name, $user, $hashed_password, $email, $phone, $dia_chi);
        
        if ($result) {
            error_log("User inserted successfully");
            return true;
        } else {
            error_log("Failed to insert user");
            return false;
        }
        
    } catch(Exception $e) {
        error_log("Error inserting user: " . $e->getMessage());
        return false;
    }
}

function check_exist($field, $value) {
    try {
        // Đảm bảo tên cột được phép
        $allowed_fields = ['user', 'email', 'phone'];
        if (!in_array($field, $allowed_fields)) {
            throw new Exception("Invalid field name");
        }
        
        $sql = "SELECT COUNT(*) as count FROM taikhoan WHERE $field = ?";
        $params = [$value]; // Đặt value vào mảng params
        
        $result = pdo_query_one($sql, $params);
        return isset($result['count']) && $result['count'] > 0;
    } catch(Exception $e) {
        error_log("Lỗi kiểm tra tồn tại: " . $e->getMessage());
        return false;
    }
}

function validate_registration($user, $email, $phone) {
    $errors = [];
    
    try {
        // Kiểm tra tên đăng nhập
        if(check_exist('user', $user)) {
            $errors[] = 'Tên đăng nhập "' . htmlspecialchars($user) . '" đã tồn tại';
        }
        
        // Kiểm tra email
        if(check_exist('email', $email)) {
            $errors[] = 'Email "' . htmlspecialchars($email) . '" đã được sử dụng';
        }
        
        // Kiểm tra số điện thoại
        if(check_exist('phone', $phone)) {
            $errors[] = 'Số điện thoại "' . htmlspecialchars($phone) . '" đã được đăng ký';
        }
        
    } catch(Exception $e) {
        error_log("Lỗi validate đăng ký: " . $e->getMessage());
        $errors[] = 'Có lỗi xảy ra trong quá trình kiểm tra thông tin';
    }
    
    return $errors;
}

function check_exist_update($field, $value, $id) {
    try {
        // Đảm bảo tên cột được phép
        $allowed_fields = ['user', 'email', 'phone'];
        if (!in_array($field, $allowed_fields)) {
            throw new Exception("Invalid field name");
        }
        
        // Kiểm tra giá trị đã tồn tại cho người dùng khác
        $sql = "SELECT COUNT(*) as count FROM taikhoan WHERE $field = ? AND id != ?";
        $params = [$value, $id];
        
        $result = pdo_query_one($sql, $params);
        return isset($result['count']) && $result['count'] > 0;
    } catch(Exception $e) {
        error_log("Lỗi kiểm tra tồn tại: " . $e->getMessage());
        return false;
    }
}

function validate_update($user, $email, $phone, $id) {
    $errors = [];
    
    try {
        // Kiểm tra tên đăng nhập
        if(check_exist_update('user', $user, $id)) {
            $errors[] = 'Tên đăng nhập "' . htmlspecialchars($user) . '" đã tồn tại';
        }
        
        // Kiểm tra email
        if(check_exist_update('email', $email, $id)) {
            $errors[] = 'Email "' . htmlspecialchars($email) . '" đã được sử dụng';
        }
        
        // Kiểm tra số điện thoại
        if(check_exist_update('phone', $phone, $id)) {
            $errors[] = 'Số điện thoại "' . htmlspecialchars($phone) . '" đã được đăng ký';
        }
        
    } catch(Exception $e) {
        error_log("Lỗi validate cập nhật: " . $e->getMessage());
        $errors[] = 'Có lỗi xảy ra trong quá trình kiểm tra thông tin';
    }
    
    return $errors;
}
