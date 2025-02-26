@extends('layouts.app')

@push('content')
<div class="container py-5" dir="rtl">
    <h2 class="mb-4 text-center">تفاصيل طلبات التكوين - {{ $formation->name }}</h2>
    
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-right me-2"></i> العودة
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>رقم الملف</th>
                    <th>الولاية</th>
                    <th>المعتمدية</th>
                    <th>تاريخ تقديم الطلب</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $demande)
                <tr>
                    <td>{{ $demande->id }}</td>
                    <td>{{ $demande->gouvernorat->name ?? 'غير محدد' }}</td>
                    <td>{{ $demande->delegation->name ?? 'غير محدد' }}</td>
                    <td>{{ $demande->created_at->translatedFormat('j F Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">لا توجد طلبات مسجلة</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $demandes->links() }}
    </div>
</div>
@endpush

@push('styles')
<style>
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .table thead th {
        background-color: #0d6efd;
        color: white;
        border-bottom: 2px solid #dee2e6;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5c636a;
    }
</style>
@endpush