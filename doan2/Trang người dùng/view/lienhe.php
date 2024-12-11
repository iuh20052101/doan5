<div class="contact-form-wrapper">
    <h2 class="page-heading heading--outcontainer">Liên hệ </h2>
    <div class="container">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            <form method="post" action="index.php?act=lienhe" class="form row">
                <p class="form__title">Gửi thắc mắc của bạn cho chúng tôi</p>
                
                <div class="col-sm-6">
                    <input type="text" placeholder="Tên của bạn" name="name" class="form__name" required>
                </div>
                <div class="col-sm-6">
                    <input type="email" placeholder="Email của bạn" name="email" class="form__mail" required>
                </div>
                <div class="col-sm-12">
                    <textarea placeholder="Thắc mắc của bạn" name="message" class="form__message" required></textarea>
                </div>
                <div class="col-sm-12">
                    <input type="submit" name="guimail" value="Gửi mail" class="btn btn-md btn--danger">
                </div>
            </form>
        </div>
    </div>
</div>
<style>
/* Điều chỉnh input fields */
.form__name, .form__mail, .form__message {
    color: black;
    background: rgba(255, 255, 255, 0.9); /* Nền trắng đục */
    border: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

/* Điều chỉnh placeholder */
::placeholder {
    color: rgba(0, 0, 0, 0.5); /* Màu đen nhạt cho placeholder */
}

/* Hiệu ứng focus */
.form__name:focus, .form__mail:focus, .form__message:focus {
    background: #ffffff;
    color: black;
    border-color: #00dbde;
    box-shadow: 0 0 10px rgba(0, 219, 222, 0.2);
}

/* Điều chỉnh màu chữ cho tiêu đề */
.page-heading {
    color: #fff;
    text-shadow: 0 0 10px rgba(0, 219, 222, 0.8),
                 0 0 20px rgba(252, 0, 255, 0.8);
}

/* Điều chỉnh màu chữ cho form title */
.form__title {
    color: #fff;
    text-shadow: 0 0 10px rgba(0, 219, 222, 0.5);
}

/* Điều chỉnh alert messages */
.alert {
    color: #fff;
    font-weight: 500;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.alert-success {
    background: rgba(0, 242, 254, 0.2);
    border-left: 4px solid #00f2fe;
}

.alert-danger {
    background: rgba(255, 107, 107, 0.2);
    border-left: 4px solid #ff6b6b;
}

/* Heading với hiệu ứng neon */
.page-heading {
    font-size: 38px;
    text-align: center;
    margin-bottom: 40px;
    position: relative;
    animation: neonText 1.5s infinite alternate;
}

@keyframes neonText {
    from {
        text-shadow: 0 0 10px #fff,
                     0 0 20px #fff,
                     0 0 30px #00dbde,
                     0 0 40px #00dbde;
    }
    to {
        text-shadow: 0 0 5px #fff,
                     0 0 10px #fff,
                     0 0 15px #fc00ff,
                     0 0 20px #fc00ff;
    }
}

/* Form inputs với hiệu ứng đẹp */
.form__name, .form__mail, .form__message {
    width: 100%;
    padding: 15px;
    margin-bottom: 20px;
    border: none;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.05);
    color: white;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.form__name:focus, .form__mail:focus, .form__message:focus {
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 0 20px rgba(0, 219, 222, 0.3);
    transform: translateY(-2px);
    outline: none;
}

/* Placeholder style */
::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Textarea style */
.form__message {
    min-height: 150px;
    resize: vertical;
}

/* Submit button với hiệu ứng gradient */
.btn--danger {
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    color: white;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn--danger:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn--danger::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
    );
    transition: 0.5s;
}

.btn--danger:hover::before {
    left: 100%;
}

/* Alert animations */
.alert {
    background: transparent;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transform-origin: top;
    animation: slideDown 0.5s ease forwards;
}

@keyframes slideDown {
    from {
        transform: translateY(-20px) scale(0.95);
        opacity: 0;
    }
    to {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

/* Success alert */
.alert-success {
    background: linear-gradient(135deg, 
        rgba(0, 242, 254, 0.1), 
        rgba(79, 172, 254, 0.1)
    );
    border-left: 4px solid #00f2fe;
}

/* Error alert */
.alert-danger {
    background: linear-gradient(135deg, 
        rgba(255, 107, 107, 0.1), 
        rgba(255, 79, 129, 0.1)
    );
    border-left: 4px solid #ff6b6b;
}

/* Form title với hiệu ứng gradient */
.form__title {
    font-size: 24px;
    margin-bottom: 30px;
    text-align: center;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    position: relative;
    padding-bottom: 10px;
}

.form__title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 2px;
    background: linear-gradient(45deg, #00dbde, #fc00ff);
}
</style>