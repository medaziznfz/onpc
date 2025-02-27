@extends('layouts.app')

@push('styles')
<!-- Sweet Alert css-->
<link href="assetsnefzi/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
    .table .sort {
        padding-right: 1.5rem;
    }
</style>
@endpush

@push('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">المطالب</h4>
            </div>
            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm"></div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="بحث...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="sort" data-sort="name">المستعمل</th>
                                    <th class="sort" data-sort="customer_id">رقم المستعمل / ب.ت.و</th>
                                    <th class="sort" data-sort="governorate">الولاية</th>
                                    <th class="sort" data-sort="email">البريد الإلكتروني</th>
                                    <th class="sort" data-sort="role">الخطة</th>
                                    <th class="sort" data-sort="action">فعل</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach($users as $user)
                                    <tr data-user-id="{{ $user->id }}" data-governorate-id="{{ $user->gouver }}" data-grade-id="{{ $user->grade_id }}">
                                        <td class="name">
                                            @if($user->grade)
                                                ({{ $user->grade->name_ar }})
                                            @endif
                                            {{ $user->name }}
                                        </td>
                                        <td class="customer_id">{{ $user->id }} / {{ $user->cin }}</td>
                                        <td class="governorate">{{ $user->governorate ? $user->governorate->name : 'الجميع' }}</td>
                                        <td class="email">
                                            <span class="badge bg-success-subtle text-success text-uppercase">{{ $user->email }}</span>
                                        </td>
                                        <td class="role">
                                            @if($user->role == 0)
                                                مستعمل
                                            @elseif($user->role == 1)
                                                جهوي 
                                            @elseif($user->role == 2)
                                                مركزي
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-success edit-item-btn" data-bs-toggle="modal" data-bs-target="#showModal">تحيين</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0);">السابق</a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0);">التالي</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit User -->
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showModalLabel">تحيين المستعمل</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        @csrf
                        <input type="hidden" id="editUserId" name="id">
                        <div class="mb-3">
                            <label for="editUserName" class="form-label">المستعمل</label>
                            <input type="text" class="form-control" id="editUserName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editUserEmail" class="form-label">البريد إلكتروني</label>
                            <input type="email" class="form-control" id="editUserEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="editUserRole" class="form-label">الخطة</label>
                            <select class="form-control" id="editUserRole" name="role">
                                <option value="0">مستعمل</option>
                                <option value="1">جهوي</option>
                                <option value="2">مركزي</option>
                            </select>
                        </div>
                        <div class="mb-3" id="gouverField" style="display: none;">
                            <label for="editUserGouver" class="form-label">الولاية</label>
                            <select class="form-control" id="editUserGouver" name="gouver">
                                @foreach($governorates as $governorate)
                                    <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="gradeField" style="display: none;">
                            <label for="editUserGrade" class="form-label">الرتبة</label>
                            <select class="form-control" id="editUserGrade" name="grade">
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary" id="saveChangesBtn">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<!-- JAVASCRIPT -->
<script src="assetsnefzi/libs/node-waves/waves.min.js"></script>
<script src="assetsnefzi/libs/feather-icons/feather.min.js"></script>
<script src="assetsnefzi/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assetsnefzi/js/plugins.js"></script>
<!--Swiper slider js-->
<script src="assetsnefzi/libs/swiper/swiper-bundle.min.js"></script>
<!-- prismjs plugin -->
<script src="assetsnefzi/libs/prismjs/prism.js"></script>
<script src="assetsnefzi/libs/list.js/list.min.js"></script>
<script src="assetsnefzi/libs/list.pagination.js/list.pagination.min.js"></script>
<!-- listjs init -->
<script src="assetsnefzi/js/pages/listjs.init.js"></script>
<!-- Sweet Alerts js -->
<script src="assetsnefzi/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-item-btn');
    const editUserForm = document.getElementById('editUserForm');
    const saveChangesBtn = document.getElementById('saveChangesBtn');
    const gouverField = document.getElementById('gouverField');
    const gradeField = document.getElementById('gradeField');
    const editUserRole = document.getElementById('editUserRole');
    const editUserGouver = document.getElementById('editUserGouver');
    const editUserGrade = document.getElementById('editUserGrade');

    // Event listener for each edit button
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const userId = row.getAttribute('data-user-id');
            // Get the text from the "name" cell and remove any grade text in parentheses.
            const rawName = row.querySelector('.name').innerText;
            const userName = rawName.replace(/\(.*\)/, '').trim();
            const userEmail = row.querySelector('.email').innerText.trim();
            const userRoleText = row.querySelector('.role').innerText.trim();
            const governorateId = row.getAttribute('data-governorate-id');
            const gradeId = row.getAttribute('data-grade-id');

            // Populate modal fields
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').value = userName;
            document.getElementById('editUserEmail').value = userEmail;

            // Determine role based on cell text
            let roleValue = 0;
            if (userRoleText.includes("جهوي")) {
                roleValue = 1;
            } else if (userRoleText.includes("مركزي")) {
                roleValue = 2;
            } else {
                roleValue = 0;
            }
            editUserRole.value = roleValue;

            // Show/hide fields based on role
            if (roleValue === 1) {
                gouverField.style.display = 'block';
                gradeField.style.display = 'block';
                editUserGouver.value = governorateId || "";
                editUserGrade.value = gradeId || "";
            } else if (roleValue === 2) {
                gouverField.style.display = 'none';
                gradeField.style.display = 'block';
                editUserGrade.value = gradeId || "";
                editUserGouver.value = "";
            } else {
                gouverField.style.display = 'none';
                gradeField.style.display = 'none';
                editUserGouver.value = "";
                editUserGrade.value = "";
            }
        });
    });

    // Dynamic role change event
    editUserRole.addEventListener('change', function () {
        const roleVal = parseInt(this.value);
        if (roleVal === 1) {
            gouverField.style.display = 'block';
            gradeField.style.display = 'block';
            editUserGouver.setAttribute('required', true);
            editUserGrade.setAttribute('required', true);
        } else if (roleVal === 2) {
            gouverField.style.display = 'none';
            gradeField.style.display = 'block';
            editUserGrade.setAttribute('required', true);
            editUserGouver.removeAttribute('required');
        } else {
            gouverField.style.display = 'none';
            gradeField.style.display = 'none';
            editUserGouver.removeAttribute('required');
            editUserGrade.removeAttribute('required');
        }
    });

    // Form submission for update
    saveChangesBtn.addEventListener('click', function () {
        const roleVal = parseInt(editUserRole.value);
        if (roleVal === 1 && (!editUserGouver.value || !editUserGrade.value)) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: 'الولاية والرتبة مطلوبة للدور الجهوي.',
                confirmButtonText: 'حسناً'
            });
            return;
        }
        if (roleVal === 2 && !editUserGrade.value) {
            Swal.fire({
                icon: 'error',
                title: 'خطأ!',
                text: 'الرتبة مطلوبة للدور المركزي.',
                confirmButtonText: 'حسناً'
            });
            return;
        }
        const formData = new FormData(editUserForm);
        fetch('/update-user', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم!',
                    text: 'تم تحديث المستعمل بنجاح.',
                    confirmButtonText: 'حسناً'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: 'حدث خطأ أثناء تحديث المستعمل.',
                    confirmButtonText: 'حسناً'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
</script>
@endpush
