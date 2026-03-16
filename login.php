<?php
session_start();
// If user is already logged in, redirect to index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | โรงเรียนสาธิตวิทยา</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.png" type="image/png">
    <style>
        body {
            background-color: var(--bg-light);
            padding-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-image {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-color-hover) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 3rem;
        }
        .login-logo {
            width: 120px;
            margin-bottom: 2rem;
            background: white;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .login-form-container {
            padding: 3rem;
            background: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border-color: #e0e0e0;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(254, 158, 199, 0.25);
            border-color: var(--primary-color);
        }
        .btn-login {
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card login-card mx-auto">
            <div class="row g-0">
                <!-- Left Side: Image/Branding -->
                <div class="col-md-6 login-image d-none d-md-flex text-center">
                    <img src="assets/images/favicon.png" alt="Logo" class="login-logo">
                    <h2 class="fw-bold mb-3">โรงเรียนสาธิตวิทยา</h2>
                    <p class="fs-5 opacity-75">ระบบบริหารจัดการสารสนเทศสำหรับบุคลากรและนักเรียน</p>
                </div>
                
                <!-- Right Side: Login Form -->
                <div class="col-md-6 login-form-container">
                    <div class="text-center mb-4 d-md-none">
                        <img src="assets/images/favicon.png" alt="Logo" width="80" class="mb-3">
                        <h4 class="fw-bold text-primary-custom">โรงเรียนสาธิตวิทยา</h4>
                    </div>
                    
                    <h3 class="fw-bold mb-1">ยินดีต้อนรับกลับมา!</h3>
                    <p class="text-muted mb-4">เข้าสู่ระบบเพื่อจัดการข้อมูลของคุณ</p>
                    
                    <div id="loginAlert" class="alert alert-danger d-none" role="alert"></div>

                    <form id="loginForm">
                        <div class="mb-4">
                            <label for="username" class="form-label fw-medium">ชื่อผู้ใช้งาน (Username / ID)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="username" name="username" placeholder="กรอกรหัสประจำตัว หรือ Username" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium text-dark d-flex justify-content-between">
                                รหัสผ่าน (Password)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control border-start-0 ps-0 border-end-0" id="password" name="password" placeholder="••••••••" required>
                                <span class="input-group-text bg-white border-start-0 text-muted cursor-pointer" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary-custom btn-login mt-2" id="btnLogin">
                            เข้าสู่ระบบ <i class="fas fa-sign-in-alt ms-1"></i>
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">หากพบปัญหาการเข้าสู่ระบบ โปรดติดต่อฝ่ายไอที (Admin)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle Password Visibility
            $('#togglePassword').on('click', function() {
                var passwordInput = $('#password');
                var icon = $(this).find('i');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Login Form Submission via AJAX
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btnLogin');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังเข้าสู่ระบบ...');
                $('#loginAlert').addClass('d-none');

                $.ajax({
                    type: 'POST',
                    url: 'auth/login_process.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            btn.removeClass('btn-primary-custom').addClass('btn-success').html('สำเร็จ! กำลังพาดาวน์... <i class="fas fa-check ms-1"></i>');
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 500);
                        } else {
                            btn.prop('disabled', false).html('เข้าสู่ระบบ <i class="fas fa-sign-in-alt ms-1"></i>');
                            $('#loginAlert').removeClass('d-none').html('<i class="fas fa-exclamation-circle me-2"></i> ' + response.message);
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('เข้าสู่ระบบ <i class="fas fa-sign-in-alt ms-1"></i>');
                        $('#loginAlert').removeClass('d-none').html('<i class="fas fa-wifi me-2"></i> การเชื่อมต่อผิดพลาด โปรดลองอีกครั้ง');
                    }
                });
            });
        });
    </script>
</body>
</html>
