@extends('layouts.app')


@php
    use App\Models\DemandeFormation;
    use App\Models\Governorate;
    use App\Models\Delegation;
    use App\Models\Formation;

    // Retrieve formation requests for the authenticated user
    $demandes = auth()->check() ? DemandeFormation::where('id_user', auth()->id())->get() : collect();

    // Status messages for the formation request
    $statuts = [
        1 => '🟡 طلبك قيد الانتظار',
        2 => '🔵 طلبك قيد المعالجة',
        3 => '🔵 طلبك قيد المعالجة',
        4 => '✅ تم قبول طلبك',
    ];
@endphp

@push('content')

<div class="container my-5" dir="rtl">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container">
        <h2 class="text-center mb-4">طلبات التكوين</h2>

        @if(!($demandes->isEmpty()))
        
            @foreach($demandes as $demande)
            <div class="certificat-card shadow-sm p-4 mb-3 bg-white rounded {{ $loop->first ? 'active' : '' }}"
                     onclick="loadCertificatDetails({{ $demande->id }})"
                     data-id="{{ $demande->id }}">
                @php
                    // Retrieve associated records using the stored IDs
                    $gouvernorat = Governorate::find($demande->gouvernerat);
                    $delegation   = Delegation::find($demande->delegation);
                    $formation    = Formation::find($demande->formation_id);
                @endphp

                
                    <div class="card-body">
                        <!-- Instead of showing id_user, we use the content from associated tables -->
                        <p><strong>رقم الملف:</strong> {{ $demande->id }}</p>
                        <p><strong>الولاية:</strong> {{ $gouvernorat ? $gouvernorat->name : 'غير محدد' }}</p>
                        <p><strong>المعتمدية:</strong> {{ $delegation ? $delegation->name : 'غير محدد' }}</p>
                        <p><strong>اسم التكوين:</strong> {{ $formation ? $formation->name : 'غير محدد' }}</p>
                        <p><strong>الحالة:</strong> <span class="fw-bold">{{ $statuts[$demande->status] ?? 'غير محدد' }}</span></p>
                    </div>
                
            </div>
            @endforeach
    </div>

    <div>
        <!-- Bouton pour afficher/cacher le formulaire de demande -->
        <div class="text-center mb-4">
            <a href="#" id="toggle-demande" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> إضافة طلب جديد
            </a>
        </div>

        <!-- Conteneur pour le formulaire de demande, masqué initialement -->
        <div id="demande-form-container-certt" style="display: none;">
            @include('formations.demande_formation')
        </div>
    </div>   

    <!-- Zone de détails initialement vide -->
    <div id="certificat-details-container" class="mt-5">
        <div class="alert alert-info text-center">
            يرجى اختيار طلب من القائمة لعرض التفاصيل
        </div>
    </div>
@else
    <div class="alert alert-info text-center"> 
        لم يتم العثور على طلبات تكوين.
    </div>

    <div>
        <!-- Bouton pour afficher/cacher le formulaire de demande -->
        <div class="text-center mb-4">
            <a href="#" id="toggle-demande" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> إضافة طلب جديد
            </a>
        </div>

        <!-- Conteneur pour le formulaire de demande, masqué initialement -->
        <div id="demande-form-container-certt" style="display: none;">
            @include('formations.demande_formation')
        </div>
    </div>  
    
@endif



</div>
@endpush


@push('scripts')
<script>
    // Bascule l'affichage du formulaire de demande
    document.getElementById('toggle-demande').addEventListener('click', function(e) {
        e.preventDefault();
        var container = document.getElementById('demande-form-container-certt');
        container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
    });

    function loadCertificatDetails(id) {
        // Affiche un loader pendant le chargement
        const container = document.getElementById('certificat-details-container');
        container.innerHTML = '<div class="text-center py-4">جاري التحميل...</div>';

        fetch(`/demandes/${id}/details`)
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                // Met à jour la classe active
                document.querySelectorAll('.certificat-card').forEach(card => {
                    card.classList.remove('active');
                });
                document.querySelector(`[data-id="${id}"]`).classList.add('active');
            })
            .catch(error => {
                container.innerHTML = '<div class="alert alert-danger">حدث خطأ أثناء التحميل</div>';
            });
    }

</script>
@endpush


@push('styles')
<style>
    .certificat-card {
        display: block;
        transition: transform 0.2s;
        text-decoration: none !important;
        color: #333;
        border: 1px solid #ddd;
    }

    .certificat-card:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .certificat-card.active {
        border-left: 4px solid #0d6efd;
        background-color: #f8f9fa;
    }

    #certificat-details-container {
        min-height: 500px;
        opacity: 1;
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
    }

    #demande-form-container-certt .form-group label {
        text-align: right;
        width: 100%;
    }
    
    #demande-form-container-certt .form-control {
        text-align: right;
    }

    .alert-info {
        background-color: #f8f9fa;
        border-color: #ddd;
    }

    .btn-outline-primary {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.75rem;
        }
    }
    /* css de demande */
    #demande-certificat {
        margin: 20px auto;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 8px;
        max-width: 800px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        direction: rtl;
        text-align: center;
    }
    #demande-certificat h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    /* Formulaire en arabe */
    #demande-certificat .form-group label {
        text-align: right;
        width: 100%;
    }
    #demande-certificat .form-control {
        text-align: right;
    }
</style>
@endpush
