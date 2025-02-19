@extends('layouts.app', ['page_title' => 'متابعة طلبك']) 

@section('styles')
<!-- Sweet Alert css-->
<link href="assetsnefzi/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />



<!-- Icons Css -->
<link href="assetsnefzi/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assetsnefzi/css/app.min.css" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="assetsnefzi/css/custom.min.css" rel="stylesheet" type="text/css" />
<style>
    .table .sort {
        padding-right: 1.5rem;
    }
</style>
@endsection

@section('content')
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
                                                <th class="sort" data-sort="customer_name">رقم الملف</th>
                                                <th class="sort" data-sort="email">الولاية</th>
                                                <th class="sort" data-sort="phone">المعتمدية </th>
                                                <th class="sort" data-sort="date">المستعمل</th>
                                                <th class="sort" data-sort="status">حالة الطلب</th>
                                                <th class="sort" data-sort="action">فعل</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
    @foreach($requests as $request)
        <tr>
            <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a></td>
            <td class="customer_name">{{ $request->id }}</td>
            <td class="email">{{ $request->gouvernorat_name }}</td> <!-- Access gouvernorat name -->
            <td class="phone">{{ $request->delegation_name }}</td> <!-- Access delegation name -->
            <td class="date">
                <a href="{{ route('show_user', $request->user_id) }}" target="_blank">
                    {{ $request->user->name }} <!-- Access user name -->
                </a>
            </td>
            <td class="status"><span class="badge bg-success-subtle text-success text-uppercase">{{ $request->statut }}</span></td>
            <td>
                <div class="d-flex gap-2">
                    <div class="edit">
                        <a href="{{ route('request.details', $request->id) }}" class="btn btn-sm btn-success edit-item-btn">تحيين</a>
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
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="javascript:void(0);">
                                            Next
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

@endsection

@section('scripts')
<!-- JAVASCRIPT -->
<script src="assetsnefzi/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assetsnefzi/libs/simplebar/simplebar.min.js"></script>
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
@endsection