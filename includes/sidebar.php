            <!-- Sidebar -->
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <nav id="sidebar" class="bg-white border-end">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column mb-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>" href="index.php">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i> แดชบอร์ด
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <?php $is_master = in_array($current_page, ['teachers.php']); ?>
                            <a class="nav-link <?= $is_master ? 'active' : '' ?>" href="#masterDataSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="<?= $is_master ? 'true' : 'false' ?>" aria-controls="masterDataSubmenu">
                                <i class="fas fa-database fa-fw me-2"></i> จัดการข้อมูลพื้นฐาน
                                <i class="fas fa-chevron-down ms-auto fa-xs mt-1"></i>
                            </a>
                            <div class="collapse <?= $is_master ? 'show' : '' ?>" id="masterDataSubmenu">
                                <ul class="nav flex-column ms-3 mb-2 submenu">
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($current_page == 'teachers.php') ? 'active text-primary fw-bold' : '' ?>" href="teachers.php"><i class="fas fa-chalkboard-teacher fa-fw me-2"></i> ข้อมูลครู</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fas fa-user-graduate fa-fw me-2"></i> ข้อมูลนักเรียน</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fas fa-book fa-fw me-2"></i> ข้อมูลรายวิชา</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fas fa-layer-group fa-fw me-2"></i> ข้อมูลระดับชั้นเรียน</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#"><i class="fas fa-door-open fa-fw me-2"></i> ข้อมูลห้องเรียน</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-calendar-alt fa-fw me-2"></i> จัดการตารางเรียน
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star fa-fw me-2"></i> บันทึกผลการเรียน
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-clock fa-fw me-2"></i> บันทึกเวลาเรียน
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users-cog fa-fw me-2"></i> จัดการผู้ใช้งาน (RBAC)
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Page Content Placeholder -->
            <main class="content-wrapper p-4 bg-light">
