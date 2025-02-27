@extends('layouts.app')

@php
use App\Models\TypeActivite;
use App\Models\Certificat;

// Récupération des certificats avec vérification d'authentification
$certificats = auth()->check() ? Certificat::where('user_id', auth()->id())->get() : collect();

// Configuration des statuts
$statuts = [
    1 => 'في الانتظار',
    2 => 'تحت المراجعة',
    3 => 'زيارة مبرمجة',
    4 => 'مكتمل'
];

// Chargement des types d'activités
$typesActivites = TypeActivite::pluck('nom', 'id')->toArray();
@endphp

@push('content')
 

<div class="container my-5" dir="rtl">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($certificats->isNotEmpty())
        <h2 class="mt-4 alert alert-info text-center">ملفات شهائد الوقاية </h2>
        <div class="certificat-container">
            @foreach($certificats as $index => $certificat)
            <a href="{{ route('certificat.details', $certificat->id) }}" class="certificat-card shadow-sm p-4 mb-3 bg-white rounded">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong>طلب رقم :</strong> {{ $index + 1 }}</p>
                            <p class="mb-1"><strong>رقم الملف :</strong> {{ $certificat->id }}</p>
                            <p class="mb-1"><strong>نوع النشاط :</strong> 
                                {{ $typesActivites[$certificat->type_activite] ?? 'غير محدد' }}
                            </p>
                        </div>
                        <div>
                            <span class="badge badge-pill 
                                {{ ['bg-secondary', 'bg-info', 'bg-warning', 'bg-success'][$certificat->statut - 1] ?? 'bg-secondary' }}">
                                {{ $statuts[$certificat->statut] ?? 'غير محددة' }}
                            </span>
                        </div>
                    </div>
                </a>
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
                @include('partials.demande_certif')
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
            لا توجد طلبات شهادة مسجلة
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
                @include('partials.demande_certif')
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


    $(document).ready(function () {
            // Soumission du formulaire de demande
            $('#demandeCertificatForm').on('submit', function(e) {
                e.preventDefault();
                // Vous pouvez ajouter ici une validation des champs si nécessaire
                this.submit();
            });

            // Lorsque le Gouvernorat est sélectionné, charger les Délégations
            $('#gouvernorat').change(function () {
                let governorateId = $(this).val();
                if (governorateId) {
                    $.ajax({
                        url: '/get-delegations',
                        type: 'GET',
                        data: { governorate_id: governorateId },
                        success: function (data) {
                            let delegationSelect = $('#delegation');
                            delegationSelect.empty().append('<option value="" selected disabled>اختر المعتمدية</option>');
                            $.each(data, function (key, delegation) {
                                delegationSelect.append('<option value="' + delegation.id + '">' + delegation.name + '</option>');
                            });
                            $('#delegation-container').removeClass('d-none');
                        },
                        error: function (xhr) {
                            console.log("خطأ أثناء تحميل المعتمديات:", xhr);
                        }
                    });
                } else {
                    $('#delegation-container, #activity-type-container').addClass('d-none');
                }
            });

            // Lorsque la Délégation est sélectionnée, afficher le Type d'activité
            $('#delegation').change(function () {
                let delegationId = $(this).val();
                if (delegationId) {
                    $('#activity-type-container').removeClass('d-none');
                } else {
                    $('#activity-type-container').addClass('d-none');
                }
            });

            // Gestion de l'affichage du type d'activité spécifique
            $('#type-activite').change(function () {
                let typeActivite = $(this).val();
                if (typeActivite == "2") {
                    $('#specific-activity-dropdown-container').removeClass('d-none');
                    $('#specific-activity-erp-dropdown-container, #other-activity-container').addClass('d-none');
                } else if (typeActivite == "1") {
                    $('#specific-activity-erp-dropdown-container').removeClass('d-none');
                    $('#specific-activity-dropdown-container, #other-activity-container').addClass('d-none');
                } else {
                    $('#specific-activity-dropdown-container, #specific-activity-erp-dropdown-container, #other-activity-container').addClass('d-none');
                }
            });

            // Afficher le champ "Autre activité" si sélection "0"
            $('#specific-activity, #specific-activity-erp').change(function () {
                let specificActivity = $(this).val();
                if (specificActivity == "0") {
                    $('#other-activity-container').removeClass('d-none');
                } else {
                    $('#other-activity-container').addClass('d-none');
                }
            });
        });
</script>
@endpush

@push('styles')
<style>
    .certificat-container {
        max-width: 800px;
        margin: 0 auto;
    }

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

    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
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
    
    .loading {
        opacity: 0.5;
        transform: translateY(10px);
    }

    #afficher-certificat {
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
    
    #afficher-certificat .container p {
        margin: 10px 0;
        font-size: 16px;
    }
    
    #afficher-certificat .container p strong {
        margin-right: 5px;
    }

    .wizard-bar {
        z-index: 1020;
        top: 0;
    }

    /* Pour que les onglets se replient sur plusieurs lignes sur petit écran */
    .nav-pills {
        flex-wrap: wrap;
    }
    
    /* Espacement entre les flèches */
    .nav-pills .nav-item {
        margin: 0 5px;
    }
    
    /* Forme géométrique pour les onglets inversée (flèche pointant à gauche) */
    .nav-pills .nav-link {
        font-size: 0.95rem;
        padding: 10px 20px;
        text-align: center;
        background: #f8f9fa;
        transition: all 0.2s;
        clip-path: polygon(20px 0, 100% 0, 100% 100%, 20px 100%, 0 50%);
        -webkit-clip-path: polygon(20px 0, 100% 0, 100% 100%, 20px 100%, 0 50%);
    }
    
    .nav-pills .nav-link.active {
        background: #0d6efd;
        color: #fff;
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
    }
    
    /* Masquer complètement les onglets inactifs pour éviter les espaces vides */
    .tab-pane:not(.show) {
        display: none;
    }
    
    .content-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    @media (max-width: 768px) {
        .nav-link {
            padding: 8px 12px !important;
            font-size: 0.85rem !important;
        }
        h1 {
            font-size: 1.75rem;
        }
    }
    
    .badge.bg-info {
        background-color: #17a2b8 !important;
        color: #fff !important;
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

    /* Styles existants pour le wizard */
    .wizard .nav-tabs {
        display: flex;
        border-bottom: none;
        position: relative;
    }
    .wizard .nav-tabs::after {
        content: "";
        position: absolute;
        width: 75%;
        height: 4px;
        background-color: #ddd;
        top: 50%;
        left: 12%;
        transform: translateY(-50%);
        z-index: -1;
    }
    .wizard .nav-tabs .nav-item .nav-link {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #f8f9fa;
        border: 2px solid #ccc;
        color: #777;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: all 0.3s ease-in-out;
    }
    .wizard .nav-tabs .nav-item .nav-link.completed {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: white;
    }
    .wizard .nav-tabs .nav-item .nav-link.active {
        background-color: white;
        border-color: #0dcaf0;
        color: #0dcaf0;
        font-weight: bold;
    }
    .wizard .nav-tabs .nav-item .nav-link.disabled {
        pointer-events: none;
        opacity: 0.5;
    }
    .badge.bg-secondary {
  background-color:rgb(78, 78, 230) !important;
}
.badge.bg-warning {
  background-color: #ffc107 !important;
  color: #000 !important; /* Pour le texte lisible sur fond jaune */
}
</style>
@endpush
