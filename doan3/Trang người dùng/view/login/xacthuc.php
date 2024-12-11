<div class="auth-wrapper">
    <div class="auth-container" style="margin-top: 100px">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">
                    Xác thực mã
                </h2>
                <div class="auth-external-container">
                </div>
                <form class="login-form" method="post" action="index.php?act=xacthuc">
                    <input type="text" class="auth-form-input" placeholder="Nhập mã xác thực từ email của bạn" name="verification_code">
                    <div class="footer-action">
                        <input type="submit" value="Xác thực" class="auth-submit" name="xacthuc">
                        <a href="index.php?act=quenmk" class="auth-btn-direct">Gửi lại mã</a>
                    </div>
                    <?php if(isset($error) && $error != "") { ?>
                        <p style="color: red;"><?php echo $error; ?></p>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</div>