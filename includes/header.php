<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบบริหารจัดการโรงเรียนสาธิตวิทยา</title>
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
</head>
<body>
    <div class="wrapper">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container-fluid">
                <button class="btn btn-primary-custom d-lg-none me-2" id="sidebarToggleBtn">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="navbar-brand text-primary-custom fw-bold" href="index.php">
                    <i class="fas fa-school me-2"></i> โรงเรียนสาธิตวิทยา
                </a>
                
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0 flex-row">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php 
                            $userName = isset($_SESSION['user_firstname']) ? $_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname'] : 'User';
                            $userRoleLabel = 'ผู้ใช้งาน';
                            if (isset($_SESSION['user_role'])) {
                                if ($_SESSION['user_role'] === 'admin') $userRoleLabel = 'ผู้ดูแลระบบ';
                                elseif ($_SESSION['user_role'] === 'teacher') $userRoleLabel = 'ครูผู้สอน';
                                elseif ($_SESSION['user_role'] === 'student') $userRoleLabel = 'นักเรียน';
                            }
                            ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($userName); ?>&background=FE9EC7&color=fff" class="rounded-circle me-2" alt="Profile" width="32" height="32">
                            <span class="d-none d-md-inline"><?php echo htmlspecialchars($userRoleLabel); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end position-absolute" aria-labelledby="userDropdown">
                            <li class="px-3 py-2 text-center text-muted border-bottom">
                                <strong><?php echo htmlspecialchars($userName); ?></strong><br>
                                <small>@<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></small>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-muted"></i> โปรไฟล์</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-muted"></i> ตั้งค่า</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/Satitschool/auth/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> ออกจากระบบ</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        
        <div class="main-container d-flex">
