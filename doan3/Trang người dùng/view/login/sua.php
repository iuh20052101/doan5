<?php 
    extract($loadtk);
?>
<div class="auth-wrapper">
    <div class="auth-container">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">
                    Sửa tài khoản
                </h2>
                <div class="auth-external-container">
                </div>
                <form class="login-form" method="post" action="index.php?act=updatetk">
                    <input type="text" class="auth-form-input" placeholder="User" name="user" value="<?=$user?>">
                    <input type="text" class="auth-form-input" placeholder="Phone" name="phone" value="<?=$phone?>">
                    <input type="email" class="auth-form-input" placeholder="Email" name="email" value="<?=$email?>">
                    <input type="text" class="auth-form-input" placeholder="Địa chỉ" name="dia_chi" value="<?=$dia_chi?>">
                    <div class="footer-action">
                        <input type="hidden" class="auth-form-input" placeholder="Name" name="id" value="<?=$id?>">
                        <input type="submit" value="Cập Nhật" class="auth-submit" name="capnhat">
                    </div>
                </form>
                <?php if(isset($thongbao) && $thongbao != ""): ?>
                    <div class="<?php echo strpos($thongbao, 'thành công') !== false ? 'success-message' : 'error-list'; ?>">
                        <?php echo htmlspecialchars($thongbao); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.auth-wrapper {
    display: flex;
    justify-content: center;
    min-height: 60vh;
    margin: 50px 0; /* Khoảng cách với header và footer */
    padding: 20px 0;
}

.auth-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
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

.footer-action {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}



.auth-submit:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
    font-weight: 900;
    transform: translateY(-2px);
}

.error-list {
    color: red;
    background-color: #fff3f3;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
    white-space: pre-line;
}
.success-message {
    color: green;
    background-color: #f0fff0;
    padding: 10px;
    border-radius: 5px;
    margin: 10px 0;
}
</style>