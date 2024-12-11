
<!-- Form without bootstrap -->

<div class="auth-wrapper">
    <div class="auth-container" style="margin-top: 100px">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">
                    Quên mật khẩu
                </h2>
                <div class="auth-external-container">
                </div>
                <form class="login-form" method="post" action="index.php?act=quenmk">
                    <input type="email" class="auth-form-input" placeholder="Nhập email đã đăng ký để nhận mật khẩu" name="email">
                    <div class="footer-action">
    <button type="submit" class="auth-btn-direct" name="guiemail">Gửi</button>
    <button type="reset" class="auth-btn-direct">Nhập Lại</button>
    <button type="button" class="auth-btn-direct" onclick="window.location.href='index.php?act=dangnhap'">Đăng nhập</button>
</div>

                    <?php if (isset($sendMailMess) && $sendMailMess != '') {
                        echo $sendMailMess;
                    } ?>
                    <?php if(isset($error)&&$error !=""){
                echo '<p  style="color: red; "
                > '.$error.' </p>';
            } ?>
                </form>
            </div>
        </div>
        
    </div>
</div>
     
<style>
 
    .footer-action {
    display: flex;

    justify-content: center; /* Canh giữa các nút */
   
}

.auth-btn-direct {
    padding: 10px 20px; /* Kích thước nút */
    font-size: 16px; /* Kích thước chữ */
    color: #fff; /* Màu chữ */
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
    font-weight: 900;
    border: none; /* Xóa viền mặc định */
    border-radius: 5px; /* Bo góc nút */
    cursor: pointer; /* Hiệu ứng con trỏ */
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu */
    text-align: center; /* Canh giữa chữ */
    text-decoration: none; /* Xóa gạch chân (nếu có) */
}


.auth-btn-direct:active {
    background-color: #00dbde; /* Màu nền khi nhấn */
}

.auth-wrapper {
    display: flex;
    justify-content: center;
    min-height: 60vh;
    margin: 50px 0;
    padding: 20px 0;
   
}

.auth-container {
    width: 100%;
    max-width: 400px;
  
}

.auth-form-outer {
    background: rgba(255, 255, 255, 0.95);
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.auth-form-title {
    text-align: center;
    font-size: 28px;
    color: #333;
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
    width: 100%;
}

.auth-form-input {
    width: 100%;
    padding: 12px 15px;
    margin: 0;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.auth-form-input:focus {
    border-color: #00dbde;
    box-shadow: 0 0 0 2px rgba(0, 219, 222, 0.1);
    outline: none;
}

.input-icon {
    position: relative;
    width: 100%;
}

.input-icon .auth-form-input {
    padding-right: 40px;
}

.input-icon .fa-eye {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
    transition: color 0.3s ease;
    z-index: 1;
}

.input-icon .fa-eye:hover {
    color: #00dbde;
}

.footer-action {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 25px;
}

.auth-submit {
    padding: 12px 30px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
}

.auth-btn-direct {
    color: #555;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.auth-btn-direct:hover {
    color: #00dbde;
}

.auth-forgot-password {
    text-align: center;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.auth-forgot-password a {
    color: #666;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
}

.auth-forgot-password a:hover {
    color: #00dbde;
}

.welcome-section {
    text-align: center;
}

.welcome-title {
    font-size: 24px;
    color: #333;
    margin-bottom: 25px;
}

.button-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn.btn-md.btn--warning {
    width: 100%;
    padding: 12px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn.btn-md.btn--warning a {
    color: white;
    text-decoration: none;
    display: block;
    text-align: center;
    font-weight: 500;
}

.btn.btn-md.btn--warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 219, 222, 0.4);
}

.error-message {
    color: #ff4444;
    text-align: center;
    padding: 10px;
    margin: 10px 0;
    background: rgba(255, 68, 68, 0.1);
    border-radius: 5px;
    font-size: 14px;
}
</style>