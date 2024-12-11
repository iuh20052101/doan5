<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">
                    Đổi mật khẩu
                </h2>
                <div class="auth-external-container">
                </div>
                <form class="login-form" method="post" action="index.php?act=doimk">
                    <input type="text" class="auth-form-input" placeholder="Nhập mật khẩu cũ" name="pass">
                    <input type="text" class="auth-form-input" placeholder="Nhập mật khẩu mới" name="passmoi">
                    <div class="input-icon">
                        <input type="password" class="auth-form-input" placeholder="Nhập lại mật khẩu" name="passmoi1">
                        <i class="fa fa-eye show-password"></i>
                    </div>
                    <div class="footer-action">
                        <input type="hidden" class="auth-form-input" placeholder="Name" name="id" value="<?=$id?>">
                        <input type="submit" value="Gửi" class="auth-submit" name="capnhat">
                        <a href="index.php?act=dangxuat" class="auth-btn-direct">Đăng nhập</a>
                    </div>
                    <?php if(isset($error)&&$error !=""){
                        echo '<p style="color: red;">'.$error.'</p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
    padding: 20px;
    margin: 20px 0;
}

.auth-form-outer {
    background: rgba(255, 255, 255, 0.9);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.auth-form-title {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.auth-form-input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.input-icon {
    position: relative;
}

.input-icon .fa-eye {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #666;
}
.auth-submit {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-align: center;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
}

.auth-submit .btn-text {
    margin-right: 10px; /* Để khoảng cách giữa "Xác nhận" và "Đăng nhập" */
}

.auth-submit .login-link {
    color: white;
    text-decoration: none;
}

.auth-submit:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.auth-submit .login-link:hover {
    text-decoration: underline;
}

</style>

