<div class="auth-wrapper">
    <div class="auth-container" style="margin-top: 100px">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">
                    Đặt lại mật khẩu
                </h2>
                <div class="auth-external-container">
                </div>
                <form class="login-form" method="post" action="index.php?act=doimk_quenpass">
                    <input type="password" class="auth-form-input" placeholder="Nhập mật khẩu mới" name="new_password">
                    <input type="password" class="auth-form-input" placeholder="Nhập lại mật khẩu mới" name="confirm_password">
                    
                    <div class="footer-action">
                        <input type="submit" value="Đổi mật khẩu" class="auth-submit" name="doimatkhau">
                    </div>
                    <?php if(isset($error) && $error != "") { ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>