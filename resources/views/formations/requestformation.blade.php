@extends('layouts.app')

@php
    use App\Models\Formation;
    use App\Models\DemandeFormation;

    $formations = Formation::withCount('demandes')->get();
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
                        <span class="badge bg-primary">
                            {{ $formation->demandes_count }} طلب
                        </span>
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
    
    .badge.bg-primary {
        background-color: #0d6efd !important;
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }
    
    .hover-shadow-lg {
        box-shadow: 0 0.15rem 0.75rem rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 768px) {
        .formation-card {
            margin-bottom: 1rem;
        }
        
        .card-title {
            font-size: 1rem;
        }
        
        .badge {
            font-size: 0.8rem;
        }
    }
</style>
@endpush