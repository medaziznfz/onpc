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
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto"></div>
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
                                <th class="sort" data-sort="customer_name">رقم المستعمل</th>
                                <th class="sort" data-sort="date">المستعمل</th>
                                <th class="sort" data-sort="email">الولاية</th>
                                <th class="sort" data-sort="phone">البريد إلكتروني</th>
                                <th class="sort" data-sort="status">الخطة</th>
                                <th class="sort" data-sort="action">فعل</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach($users as $user)
                                <tr>
                                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
                                    <td class="customer_name">{{ $user->cin }}</td>
                                    <td class="email">{{ $user->name }}</td> 
                                    <td class="phone">
                                        @if($user->governorate_name)
                                            {{ $user->governorate_name }}
                                        @else
                                            الجميع
                                        @endif
                                    </td> <!-- Display governorate name or "الجميع" if null -->
                                    <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">{{ $user->email }}</span></td>
                                    <td class="date">{{ $user->role }}</td> 
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
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                <h5 class="mt-2">عذرا! لم يتم العثور على أي نتيجة</h5>
                                <p class="text-muted mb-0">لقد قمنا بالبحث عن أكثر من 150+ طلبًا ولم نعثر على أي طلبات لبحثك.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                السابق
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0);">
                                التالي
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<!-- Modal -->
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
                        <label for="editUserGouver" class="form-label">الولاية</label>
                        <select class="form-control" id="editUserGouver" name="gouver">
                            <option value="">الجميع</option> <!-- Option for null -->
                            @foreach($governorates as $governorate)
                                <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editUserRole" class="form-label">الخطة</label>
                        <input type="text" class="form-control" id="editUserRole" name="role">
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

    // Add event listeners to all "تحيين" buttons
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const userId = row.querySelector('.customer_name').innerText;
            const userName = row.querySelector('.email').innerText;
            const userEmail = row.querySelector('.status').innerText;
            const userGouver = row.querySelector('.phone').innerText;
            const userRole = row.querySelector('.date').innerText;

            // Populate the modal fields with the current user data
            document.getElementById('editUserId').value = userId;
            document.getElementById('editUserName').value = userName;
            document.getElementById('editUserEmail').value = userEmail;
            document.getElementById('editUserGouver').value = userGouver === "الجميع" ? "" : userGouver; // Handle "الجميع"
            document.getElementById('editUserRole').value = userRole;
        });
    });

    // Handle form submission when "حفظ التغييرات" is clicked
    saveChangesBtn.addEventListener('click', function () {
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
                    // Update the table row dynamically
                    const row = document.querySelector(`tr[data-user-id="${data.user.id}"]`);
                    if (row) {
                        row.querySelector('.email').innerText = data.user.name;
                        row.querySelector('.status').innerText = data.user.email;
                        row.querySelector('.phone').innerText = data.user.governorate_name || "الجميع"; // Handle "الجميع"
                        row.querySelector('.date').innerText = data.user.role;
                    }

                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('showModal'));
                    modal.hide();
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