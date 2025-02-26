@extends('layouts.app')

@php
    use App\Models\Formation;
    
    $formations = Formation::withCount([
        'demandes as pending_demandes' => function($query) {
            $query->where('status', 1);
        },
        'demandes as accepted_demandes' => function($query) {
            $query->where('status', 2);
        }
    ])->get();
@endphp

@push('content')
<div class="container py-5" dir="rtl">
    <h1 class="mb-4 text-center">إدارة طلبات التكوين</h1>
    
    <div class="row">
        @foreach($formations as $formation)
        <div class="col-md-4 mb-4">
            <div class="formation-card card h-100 shadow-sm hover-shadow-lg transition-all">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title h5 mb-0">{{ $formation->name }}</h3>
                        <div class="badges-container">
                            <span class="badge bg-primary me-1">
                                {{ $formation->pending_demandes }} طلب معلق
                            </span>
                            <span class="badge bg-success">
                                {{ $formation->accepted_demandes }} طلب مقبول
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                    <a href="{{ route('formations.requests', $formation) }}" 
                    class="btn btn-outline-secondary w-100">
                        <i class="fas fa-list-alt me-2"></i>عرض التفاصيل
                    </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($formations->isEmpty())
    <div class="alert alert-info text-center">
        لا توجد تكوينات متاحة حالياً
    </div>
    @endif
</div>
@endpush

@push('styles')
<style>
    .formation-card {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .formation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.75em;
    }
    
    .bg-primary {
        background-color: #0d6efd !important;
    }
    
    .bg-success {
        background-color: #28a745 !important;
    }
    
    .badges-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.3rem;
        justify-content: flex-end;
    }
    
    @media (max-width: 768px) {
        .formation-card {
            margin-bottom: 1rem;
        }
        
        .card-title {
            font-size: 1rem;
        }
        
        .badge {
            font-size: 0.7rem;
        }
    }
</style>
@endpush