<?php

require_once 'config/session_check.php';
// Only Admin can access
checkRole(['admin']);
include 'includes/header.php';

?>
<?php include 'includes/sidebar.php'; ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">จัดการข้อมูลครู (Teachers)</h1>
        <p class="text-muted mb-0">เพิ่ม ลบ แก้ไข ข้อมูลบุคลากรครูในระบบ</p>
    </div>
    <button class="btn btn-primary-custom px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
        <i class="fas fa-plus me-2"></i> เพิ่มข้อมูลครู
    </button>
</div>

<!-- Data Table Card -->
<div class="card shadow-sm mb-4">
    <div class="card-header py-3 bg-white border-bottom">
        <h6 class="m-0 fw-bold text-primary-custom"><i class="fas fa-list me-2"></i>รายชื่อครูทั้งหมด</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-100" id="teachersTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">รูปโปรไฟล์</th>
                        <th width="12%">รหัสประจำตัว</th>
                        <th width="20%">ชื่อ - นามสกุล</th>
                        <th width="13%">เบอร์โทรศัพท์</th>
                        <th width="10%">Line ID</th>
                        <th width="15%">หมวดวิชา</th>
                        <th width="5%">สถานะ</th>
                        <th width="10%">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary-custom text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i> เพิ่มข้อมูลครูใหม่</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTeacherForm">
                <div class="modal-body p-4">
                    <div class="alert alert-info small mb-4">
                        <i class="fas fa-info-circle me-1"></i> ระบบจะสร้างบัญชีผู้ใช้ให้โดยอัตโนมัติ โดยใช้ <strong>รหัสประจำตัวครู</strong> เป็นทั้ง Username และ Password เริ่มต้น
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">รหัสประจำตัวครู <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="teacher_code" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Line ID</label>
                            <input type="text" class="form-control" name="line_id">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">รูปโปรไฟล์ (เฉพาะ JPG, PNG, GIF ไม่เกิน 2MB)</label>
                        <input type="file" class="form-control" name="profile_image" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">หมวดวิชา <span class="text-danger">*</span></label>
                        <select class="form-select" name="department" required>
                            <option value="">-- เลือกหมวดวิชา --</option>
                            <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                            <option value="คณิตศาสตร์">คณิตศาสตร์</option>
                            <option value="ภาษาไทย">ภาษาไทย</option>
                            <option value="ภาษาต่างประเทศ">ภาษาต่างประเทศ</option>
                            <option value="สังคมศึกษาฯ">สังคมศึกษาฯ</option>
                            <option value="ศิลปะ">ศิลปะ</option>
                            <option value="สุขศึกษาและพลศึกษา">สุขศึกษาและพลศึกษา</option>
                            <option value="การงานอาชีพและเทคโนโลยี">การงานอาชีพและเทคโนโลยี</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary-custom" id="btnSaveAdd">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="editTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-edit me-2"></i> แก้ไขข้อมูลครู</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTeacherForm">
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted">รหัสประจำตัวครู (ไม่สามารถแก้ไขได้)</label>
                        <input type="text" class="form-control bg-light" id="edit_teacher_code" readonly>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" name="phone" id="edit_phone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Line ID</label>
                            <input type="text" class="form-control" name="line_id" id="edit_line_id">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">เปลี่ยนรูปโปรไฟล์ (อัปโหลดใหม่จะแทนที่รูปเดิม)</label>
                        <input type="file" class="form-control" name="profile_image" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">หมวดวิชา <span class="text-danger">*</span></label>
                        <select class="form-select" name="department" id="edit_department" required>
                            <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                            <option value="คณิตศาสตร์">คณิตศาสตร์</option>
                            <option value="ภาษาไทย">ภาษาไทย</option>
                            <option value="ภาษาต่างประเทศ">ภาษาต่างประเทศ</option>
                            <option value="สังคมศึกษาฯ">สังคมศึกษาฯ</option>
                            <option value="ศิลปะ">ศิลปะ</option>
                            <option value="สุขศึกษาและพลศึกษา">สุขศึกษาและพลศึกษา</option>
                            <option value="การงานอาชีพและเทคโนโลยี">การงานอาชีพและเทคโนโลยี</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">สถานะการใช้งาน</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="active">ปกติ (Active)</option>
                            <option value="inactive">ระงับการใช้งาน (Inactive)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-warning text-dark fw-bold" id="btnSaveEdit">อัปเดตข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#teachersTable').DataTable({
        "processing": true,
        "ajax": {
            "url": "api/teachers/read.php",
            "dataSrc": function(json) {
                if(!json.success && json.message === 'Unauthorized') {
                    Swal.fire('ปฏิเสธการเข้าถึง', 'คุณไม่มีสิทธิ์เข้าใช้งานหน้านี้', 'error').then(() => {
                        window.location.href = 'index.php';
                    });
                    return [];
                }
                return json.data;
            }
        },
        "columns": [
            { "data": null, "render": function (data, type, row, meta) { return meta.row + 1; } },
            { "data": "profile_image", "render": function(data) {
                if (data) {
                    return `<img src="assets/images/profiles/${data}" alt="Profile" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">`;
                }
                return '<div class="bg-secondary text-white rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 40px; height: 40px;"><i class="fas fa-user"></i></div>';
            }},
            { "data": "teacher_code" },
            { "data": null, "render": function(data, type, row) { 
                return row.first_name + ' ' + row.last_name; 
            }},
            { "data": "phone", "render": function(data) { return data ? data : '-'; } },
            { "data": "line_id", "render": function(data) { 
                return data ? `<span class="text-success"><i class="fab fa-line me-1"></i>${data}</span>` : '-'; 
            } },
            { "data": "department" },
            { "data": "status", "render": function(data) {
                if(data === 'active') return '<span class="badge bg-success">ปกติ</span>';
                return '<span class="badge bg-danger">ระงับ</span>';
            }},
            { "data": null, "render": function(data, type, row) {
                return `
                    <button class="btn btn-sm btn-warning text-dark btn-edit" data-id="${row.id}" data-user="${row.user_id}" data-bs-toggle="tooltip" title="แก้ไข"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}" data-name="${row.first_name} ${row.last_name}" data-bs-toggle="tooltip" title="ลบ"><i class="fas fa-trash"></i></button>
                `;
            }, "orderable": false, "searchable": false}
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        }
    });

    // Variable to hold current row data for editing
    var teachersData = [];
    table.on('xhr', function () {
        var json = table.ajax.json();
        teachersData = json ? json.data : [];
    });

    // === Create Request ===
    $('#addTeacherForm').submit(function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var formData = new FormData(form);
        var btn = $('#btnSaveAdd');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...');

        $.ajax({
            url: 'api/teachers/create.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#addTeacherModal').modal('hide');
                    form.reset();
                    table.ajax.reload(null, false);
                    Swal.fire('สำเร็จ', response.message, 'success');
                } else {
                    Swal.fire('ข้อผิดพลาด', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html('บันทึกข้อมูล');
            }
        });
    });

    // === Open Edit Modal ===
    $('#teachersTable').on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        var teacher = teachersData.find(t => t.id == id);
        
        if (teacher) {
            $('#edit_id').val(teacher.id);
            $('#edit_teacher_code').val(teacher.teacher_code);
            $('#edit_first_name').val(teacher.first_name);
            $('#edit_last_name').val(teacher.last_name);
            $('#edit_phone').val(teacher.phone);
            $('#edit_line_id').val(teacher.line_id);
            $('#edit_department').val(teacher.department);
            $('#edit_status').val(teacher.status);
            
            // Clear file input
            $('#editTeacherForm').find('input[type="file"]').val('');
            
            $('#editTeacherModal').modal('show');
        }
    });

    // === Update Request ===
    $('#editTeacherForm').submit(function(e) {
        e.preventDefault();
        var form = $(this)[0];
        var formData = new FormData(form);
        var btn = $('#btnSaveEdit');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังบันทึก...');

        $.ajax({
            url: 'api/teachers/update.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#editTeacherModal').modal('hide');
                    table.ajax.reload(null, false);
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: response.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('ข้อผิดพลาด', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('ข้อผิดพลาด', 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html('อัปเดตข้อมูล');
            }
        });
    });

    // === Delete Request ===
    $('#teachersTable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            html: `คุณต้องการลบข้อมูลของ <b>${name}</b> ใช่หรือไม่?<br><span class="text-danger small">การลบนี้จะจำกัดสิทธิ์การเข้าสู่ระบบ (Login) ของครูท่านนี้ด้วย</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#secondary',
            confirmButtonText: 'ใช่, ฉันต้องการลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/teachers/delete.php',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            table.ajax.reload(null, false);
                            Swal.fire('สำเร็จ', response.message, 'success');
                        } else {
                            Swal.fire('ข้อผิดพลาด', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('ข้อผิดพลาด', 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
