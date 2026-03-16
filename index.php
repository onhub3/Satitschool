<?php 
require_once 'config/session_check.php';
include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">แดชบอร์ดผู้บริหาร</h1>
        <p class="text-muted mb-0">ภาพรวมระบบบริหารจัดการโรงเรียนสาธิตวิทยา</p>
    </div>
    <span class="badge bg-primary-custom px-3 py-2 fs-6 shadow-sm"><i class="fas fa-calendar-alt me-1"></i> ปีการศึกษา 2569</span>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <!-- Stat Card 1 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-4 border-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">นักเรียนทั้งหมด</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">1,250 <span class="fs-6 text-muted fw-normal">คน</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-primary text-white opacity-75">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-4 border-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">บุคลากรครู</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">85 <span class="fs-6 text-muted fw-normal">คน</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-success text-white opacity-75">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-4 border-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">รายวิชาเปิดสอน</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">120 <span class="fs-6 text-muted fw-normal">วิชา</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-info text-white opacity-75">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100 py-2 border-start border-4 border-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">จำนวนห้องเรียน</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">45 <span class="fs-6 text-muted fw-normal">ห้อง</span></div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-warning text-white opacity-75">
                            <i class="fas fa-door-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Bar Chart -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header py-3 bg-white border-bottom">
                <h6 class="m-0 fw-bold text-primary-custom"><i class="fas fa-chart-bar me-2"></i>สถิติการมาเรียน (สัปดาห์นี้)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Doughnut Chart -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header py-3 bg-white border-bottom">
                <h6 class="m-0 fw-bold text-primary-custom"><i class="fas fa-chart-pie me-2"></i>ภาพรวมผลการเรียน (ปีที่ผ่านมา)</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
