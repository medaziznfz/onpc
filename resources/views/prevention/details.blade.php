@extends('layouts.app', ['page_title' => 'متابعة طلبك']) 

@push('content')
    @php
        use App\Models\Document;
        use App\Models\Certificat;

        // Récupérer tous les documents disponibles
        $documents = Document::all();
        // Récupérer les IDs des documents déjà sélectionnés
        $selectedDocumentIds = $certificat->documents->pluck('id')->toArray();
        $steps = [
                'step1' => 'المستندات المطلوبة',
                'step2' => ' تحقق من المستندات',
                'step3' => 'زيارة المنشأة',
                'step4' => 'الشهادة جاهزة'
            ];
            $currentStep = $certificat->statut;

    @endphp
    <div class="container my-5" dir="rtl">
    <h1 class="mt-4 alert alert-info text-center">  متابعة المطالب </h1>
        <div class="card shadow-sm mb-4 ">
            <div class="card-body ">
                @include('partials.afficher_certif', ['certificat' => $certificat])
            </div>
        </div> 


            <!-- Navigation du processus -->
            <div class="wizard-bar sticky-top bg-white py-3">
                <ul class="nav nav-pills justify-content-center gap-3" role="tablist">
                    @foreach($steps as $key => $title)
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 
                                {{ $loop->iteration == $currentStep ? 'active' : ($loop->iteration < $currentStep ? '' : 'disabled') }}"
                               data-bs-toggle="tab" 
                               href="#{{ $key }}" 
                               role="tab">
                                {{ $title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Contenu des étapes -->
            <div class="tab-content pt-4">
                <!-- Étape 1 : تفاصيل الطلب -->
                <div class="tab-pane fade {{ $currentStep == 1 ? 'show active' : '' }}" id="step1" role="tabpanel">
                    <div class="card shadow-sm mb-4">
                        

                        <div class="card-body">
                            @include('partials.selection_doc')
                        </div>
                        
                    </div>
                </div>

                <!-- Étape 2 : المستندات والمواعيد -->
                <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="step2" role="tabpanel">
                    <div class="content-container">
                        <div class="card-body">
                            <div class="alert alert-success">
                                <h3 class="alert-heading">تحقق من المستندات</h3>
                                <p>في حال تم التحقق من جميع المستندات من قبل مكتب الوقاية، يمكنك تأكيد هذه الخطوة بالضغط على زر "تحقق من المستندات".</p>
                            </div>

                            <!-- Formulaire pour valider les documents -->
                            <form id="validate-documents-form" action="{{ route('certificat.validate.documents', $certificat->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">
                                    تحقق من المستندات
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Étape 3 : الزيارة -->
                <div class="tab-pane fade {{ $currentStep == 3 ? 'show active' : '' }}" id="step3" role="tabpanel">
                    <div class="content-container">
                        <div class="card-body">
                            @include('partials.visite_aff')

                            <div class="action-buttons mt-4">
                                <!-- Bouton Valider le step -->
                                <form id="validate-step-form" action="{{ route('certificat.validate.step', $certificat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary me-2">
                                        تأكيد المرحلة
                                    </button>
                                </form>

                                <!-- Bouton Ajouter une visite -->
                                <button type="button" 
                                        class="btn btn-success" 
                                        id="show-add-visite"
                                        data-certificat-id="{{ $certificat->id }}">
                                    إضافة زيارة
                                </button>
                            </div>

                            <div id="add-visite-container" class="d-none">
                                @include('partials.add_visite')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 4 : الشهادة جاهزة -->
                <div class="tab-pane fade {{ $currentStep == 4 ? 'show active' : '' }}" id="step4" role="tabpanel">
                    <div class="content-container text-center py-5">
                        <div class="alert alert-success">
                            <h3 class="alert-heading">الشهادة جاهزة</h3>
                            <p>شهادتك متوفرة وجاهزة للاستلام.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
@endpush

@push('styles')
<style>

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
    .btn-success {
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }
    .action-buttons {
    margin-bottom: 20px;
    text-align: center;
    }

    .action-buttons .btn {
        margin: 5px;
        padding: 10px 25px;
        font-size: 1rem;
    }

    #add-visite-container {
    transition: all 0.3s ease;
    margin-top: 20px;
    border-top: 2px solid #eee;
    padding-top: 20px;
}

</style>
@enspush
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // ----------- Code existant pour les onglets -----------
    // Défilement fluide
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function() {
            window.scrollTo({
                top: document.querySelector('.tab-content').offsetTop - 80,
                behavior: 'smooth'
            });
        });
    });

    // Ajustement hauteur contenu
    function adjustContentHeight() {
        document.querySelector('.tab-content').style.minHeight = 
            (window.innerHeight - document.querySelector('.wizard-bar').offsetHeight - 200) + "px";
    }
    adjustContentHeight();
    window.addEventListener('resize', adjustContentHeight);

    // ----------- Validation des documents (étape 2) -----------
    document.getElementById('validate-documents-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => response.json())
        .then(data => console.log(data)) // Remplace par ton traitement
        .catch(error => console.error('Erreur:', error));
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                window.location.reload();
            },
            
        });
        
    });

    // ----------- Gestion de l'étape 3 -----------
    // Afficher/Masquer le formulaire d'ajout de visite
    document.getElementById('show-add-visite')?.addEventListener('click', function() {
        console.log('clicked');
        document.getElementById('add-visite-container')?.classList.toggle('d-none');
    });

    // Gestion de l'ajout de visite
    $('#show-add-visite').on('click', function() {
        const certificatId = $(this).data('certificat-id');
        
        // Mettre à jour le statut de la dernière visite
        $.ajax({
            url: `/certificat/${certificatId}/update-last-visite`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success) {
                    $('#add-visite-container').removeClass('d-none');
                }
            },
            error: function(xhr) {
                console.error('Erreur lors de la mise à jour du statut');
            }
        });
    });

    // Validation de l'étape
    $('#validate-step-form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                console.error("Erreur:", xhr.responseText);
                alert("خطأ في العملية");
            }
        });
    });
});

</script>
@endpush