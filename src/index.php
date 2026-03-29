<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Member Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">ระบบจัดการข้อมูลสมาชิก</h4>
            <button class="btn btn-light btn-sm" onclick="openModal('create')">+ เพิ่มสมาชิก</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th><th>รหัสประจำตัว</th><th>ชื่อ-นามสกุล</th><th>คณะ</th><th>จัดการ</th>
                    </tr>
                </thead>
                <tbody id="memberData"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="memberModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">ฟอร์มสมาชิก</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="memberForm">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="action" name="action" value="create">
            <div class="mb-3">
                <label>รหัสประจำตัว</label>
                <input type="text" class="form-control" id="member_id" name="member_id" required>
            </div>
            <div class="mb-3">
                <label>ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="mb-3">
                <label>คณะต้นสังกัด</label>
                <input type="text" class="form-control" id="faculty" name="faculty" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">บันทึกข้อมูล</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>

<script>
$(document).ready(function() {
    loadData();

    $('#memberForm').submit(function(e) {
        e.preventDefault();
        $.post('action/member_action.php', $(this).serialize(), function(res) {
            let data = JSON.parse(res);
            if(data.status === 'success') {
                $('#memberModal').modal('hide');
                loadData();
                $('#memberForm')[0].reset();
            }
        });
    });
});

function loadData() {
    $.get('action/member_action.php', {action: 'read'}, function(res) {
        let data = JSON.parse(res);
        let rows = '';
        data.forEach(row => {
            rows += `<tr>
                <td>${row.id}</td>
                <td>${row.member_id}</td>
                <td>${row.fullname}</td>
                <td>${row.faculty}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editData(${row.id}, '${row.member_id}', '${row.fullname}', '${row.faculty}')">แก้ไข</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteData(${row.id})">ลบ</button>
                </td>
            </tr>`;
        });
        $('#memberData').html(rows);
    });
}

function openModal(type) {
    $('#memberForm')[0].reset();
    $('#action').val(type);
    $('#modalTitle').text(type === 'create' ? 'เพิ่มข้อมูลใหม่' : 'แก้ไขข้อมูล');
    $('#memberModal').modal('show');
}

function editData(id, member_id, fullname, faculty) {
    openModal('update');
    $('#id').val(id);
    $('#member_id').val(member_id);
    $('#fullname').val(fullname);
    $('#faculty').val(faculty);
}

function deleteData(id) {
    $.confirm({
        title: 'ยืนยันการลบ?',
        content: 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?',
        type: 'red',
        buttons: {
            confirm: {
                text: 'ลบเลย',
                btnClass: 'btn-danger',
                action: function () {
                    $.post('action/member_action.php', {action: 'delete', id: id}, function(res) {
                        loadData();
                    });
                }
            },
            cancel: { text: 'ยกเลิก' }
        }
    });
}
</script>
</body>
</html>