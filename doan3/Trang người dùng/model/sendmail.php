<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


function sendEmail($name, $email, $message) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0; // Tắt debug trong production
        //Server settings
        $mail->isSMTP();                                            
        $mail->Host = 'smtp.gmail.com';                     
        $mail->SMTPAuth = true;                                   
        $mail->Username = 'haibang741@gmail.com';  // Email gửi                   
        $mail->Password = 'wiud ljdp mkkh zzuz';                               
        $mail->SMTPSecure = 'tls';            
        $mail->Port = 587;                                    
        $mail->CharSet = 'UTF-8';

        //Recipients
        $mail->setFrom('vominhtien10092002@gmail.com', 'TIAMS Cinema');
        $mail->addAddress('haibang741@gmail.com');  // Đổi thành chính email gửi để test     
        $mail->addReplyTo($email, $name);

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = "Liên hệ từ khách hàng: " . $name;
        $mail->Body = "
            <h3>Thông tin liên hệ mới:</h3>
            <p><strong>Họ tên:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Nội dung:</strong></p>
            <p>{$message}</p>
        ";

        error_log("Bắt đầu gửi mail từ: $email");
        $mail->send();
        error_log("Đã gửi mail thành công từ: $email đến: haibang741@gmail.com");
        return true;
    } catch (Exception $e) {
        error_log("Chi tiết lỗi gửi mail từ $email: " . $mail->ErrorInfo);
        return "Lỗi gửi mail: " . $e->getMessage();
    }
}
?>