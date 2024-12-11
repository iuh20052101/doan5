<head>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
function validateForm() {
    const password = document.querySelector('input[name="pass"]').value;
    const phone = document.querySelector('input[name="phone"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const name = document.querySelector('input[name="name"]').value;
    const user = document.querySelector('input[name="user"]').value;
    const checkbox = document.querySelector('input[name="email1"]');
    let isValid = true;
    let errorMessage = '';

    // Kiểm tra điều khoản
    if (!checkbox.checked) {
        errorMessage += '- Vui lòng đồng ý với điều khoản và chính sách bảo mật\n';
        isValid = false;
    }

    // Kiểm tra tên người dùng
    if (!name.trim()) {
        errorMessage += '- Vui lòng nhập tên người dùng\n';
        isValid = false;
    }

    // Kiểm tra tên đăng nhập
    if(!/^[A-Za-z0-9]{4,20}$/.test(user)) {
        errorMessage += '- Tên đăng nhập phải từ 4-20 ký tự, chỉ bao gồm chữ cái và số\n';
        isValid = false;
    }

    // Kiểm tra độ mạnh của mật khẩu
    if(!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
        errorMessage += '- Mật khẩu phải có ít nhất:\n  + 8 ký tự\n  + 1 chữ hoa\n  + 1 chữ thường\n  + 1 số\n  + 1 ký tự đặc biệt (@$!%*?&)\n';
        isValid = false;
    }

    // Kiểm tra định dạng số điện thoại Việt Nam
    if(!/^(0[3|5|7|8|9])+([0-9]{8})$/.test(phone)) {
        errorMessage += '- Số điện thoại không hợp lệ (phải là số điện thoại Việt Nam)\n';
        isValid = false;
    }

    // Kiểm tra định dạng email
    if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errorMessage += '- Email không hợp lệ\n';
        isValid = false;
    }

    // Kiểm tra recaptcha
    if(grecaptcha.getResponse() == "") {
        errorMessage += '- Vui lòng xác nhận captcha\n';
        isValid = false;
    }

    if(!isValid) {
        alert('Vui lòng sửa các lỗi sau:\n' + errorMessage);
        return false;
    }

    return true;
}

// Hiển thị/ẩn mật khẩu
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.querySelector('.show-password');
    const password = document.querySelector('input[name="pass"]');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
});
</script>
<style>
    .login-form{width:100%}
.auth-btn-direct {
    padding: 10px 20px; /* Kích thước nút */
    font-size: 16px; /* Kích thước chữ */
    color: #fff; /* Màu chữ */
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
    border: none; /* Xóa viền mặc định */
    border-radius: 5px; /* Bo góc nút */
    cursor: pointer; /* Hiệu ứng con trỏ */
    transition: background-color 0.3s ease; /* Hiệu ứng chuyển màu */
    text-align: center; /* Canh giữa chữ */
    text-decoration: none; /* Xóa gạch chân */
   
   
}

.auth-btn-direct:hover {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: none;
 
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
    background: rgba(255, 255, 255, 0.02);
}

.auth-container {
    /* width: 100%;
    max-width: 400px; */
    padding: 20px;
    margin-top: 40px !important;
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
.footer-action {
    display: flex;

    justify-content: center; /* Canh giữa các nút */
    margin-top: 20px; /* Khoảng cách trên */
}

.checkbox-wrapper {
    margin: 15px 0;
    padding: 10px 0;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 14px;
    color: #333;
    position: relative;
}

.checkbox-label input[type="checkbox"] {
    margin-right: 10px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    opacity: 1;
    position: relative;
    z-index: 1;
}

.checkbox-text {
    line-height: 1.4;
    margin-left: 5px;
}

.checkbox-text a {
    color: #e53637;
    text-decoration: none;
    font-weight: 500;
}

.checkbox-text a:hover {
    text-decoration: underline;
}

.checkbox-label input[type="checkbox"]:checked {
    background-color: #e53637;
    border-color: #e53637;
}

input[type="checkbox"] {
    -webkit-appearance: checkbox !important;
    -moz-appearance: checkbox !important;
    appearance: checkbox !important;
    display: inline-block !important;
    opacity: 1 !important;
}

</style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-container" style="margin-top: 50px">
        <div class="auth-action-left">
            <div class="auth-form-outer">
                <h2 class="auth-form-title">Đăng ký tài khoản</h2>
                
                <form class="login-form" method="post" action="index.php?act=dangky" onsubmit="return validateForm()">
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                    
                    <div class="input-group"><input type="text" class="auth-form-input" placeholder="Tên người dùng" name="name" required>
                    </div>

                    <div class="input-group">
                        <input type="text" class="auth-form-input" placeholder="Tên đăng nhập" name="user" required>
                        <div class="password-requirements">Tên đăng nhập từ 4-20 ký tự, chỉ bao gồm chữ cái và số</div>
                    </div>

                    <div class="input-group">
                        <div class="input-icon">
                            <input type="password" class="auth-form-input" placeholder="Mật khẩu" name="pass" required>
                            <i class="fa fa-eye show-password"></i>
                        </div>
                        <div class="password-requirements">
                            Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt
                        </div>
                    </div>

                    <div class="input-group">
                        <input type="text" class="auth-form-input" placeholder="Số điện thoại" name="phone" required>
                        <div class="password-requirements">Số điện thoại Việt Nam (VD: 0912345678)</div>
                    </div>

                    <div class="input-group">
                        <input type="email" class="auth-form-input" placeholder="Email" name="email" required>
                    </div>

                    <div class="input-group">
                        <input type="text" class="auth-form-input" placeholder="Địa chỉ" name="dia_chi" required>
                    </div>

                    <div class="g-recaptcha mb-3" data-sitekey="6LcV0ZcqAAAAACAkf5n7Bvn0IDprfdVIiL_Eju9C"></div>

                    <div class="checkbox-wrapper">
                        <label class="checkbox-label">
                            <input type="checkbox" name="email1" required>
                            <span class="checkbox-text">Tôi đồng ý với <a href="#">Điều khoản</a> và <a href="#">Chính sách bảo mật</a></span>
                        </label>
                    </div>

                    <div class="footer-action">
    <button type="submit" class="auth-btn-direct" name="dangky">Đăng ký</button>
    <button type="button" class="auth-btn-direct" onclick="window.location.href='index.php?act=dangnhap'">Đăng nhập</button>
</div>

                </form>

                <?php if(isset($thongbao) && $thongbao != ""): ?>
                    <div class="error-list"><?php echo htmlspecialchars($thongbao); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>