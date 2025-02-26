@extends('layouts.app')

@push('content')
<div class="container">
    <h1 class="mb-4">تفاصيل الشهادة</h1>

    <div class="card">
        <div class="card-body">
            @if($certificate)
                <h5 class="card-title">معلومات الشهادة</h5>
                <dl class="row">
                    <dt class="col-sm-3">الممنوحة لـ:</dt>
                    <dd class="col-sm-9">{{ $certificate->user->name }}</dd>

                    <dt class="col-sm-3">تاريخ الإصدار:</dt>
                    <dd class="col-sm-9">{{ $certificate->created_at->format('Y-m-d') }}</dd>

                    <dt class="col-sm-3">المحافظة:</dt>
                    <dd class="col-sm-9">{{ $certificate->gouvernorat_name }}</dd>

                    <dt class="col-sm-3">المنطقة:</dt>
                    <dd class="col-sm-9">{{ $certificate->delegation_name }}</dd>

                    <dt class="col-sm-3">نوع النشاط:</dt>
                    <dd class="col-sm-9">{{ $certificate->type_activite_name }}</dd>

                    <dt class="col-sm-3">تاريخ التحقق:</dt>
                    <dd class="col-sm-9">{{ $certificate->verified_at ? $certificate->verified_at : 'N/A' }}</dd>

                    <dt class="col-sm-3">تاريخ الانتهاء:</dt>
                    <dd class="col-sm-9">{{ $certificate->expiry_at ? $certificate->expiry_at : 'N/A' }}</dd>
                </dl>
            @else
                <div class="alert alert-danger">
                    لم يتم العثور على الشهادة
                </div>
            @endif

            <!-- Centering the button using Bootstrap flex utility -->
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('qrscanner.scan') }}" class="btn btn-primary">
                    مسح رمز آخر
                </a>
            </div>
        </div>
    </div>
</div>
@endpush
