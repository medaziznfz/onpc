<div>
    <h1 class="text-center mb-4 mt-2 ">متابعة الطلب</h1>
    
    @php
        $steps = [
            'step1' => 'تفاصيل الطلب',
            'step2' => 'المستندات والمواعيد',
            'step3' => 'زيارة المنشأة',
            'step4' => 'الشهادة جاهزة'
        ];
        $currentStep = $certificat->statut;
    @endphp

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
                            @include('partials.afficher_certif', ['certificat' => $certificat])
                        </div>
                    </div>
                </div>

                <!-- Étape 2 : المستندات والمواعيد -->
                <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="step2" role="tabpanel">
                    <div class="content-container">
                        <div class="alert alert-success">
                            <h3 class="alert-heading">ملاحظة</h3>
                            <p>يجب تقديم هذه الوثائق إلى مقر الإدارة الجهوية للحماية المدنية أو إلى مقر فرقة الحماية المدنية التي توجد البناية بدائرتها الترابية:</p>
                        </div>

                        <ul class="list-group">
                            @foreach($certificat->documents as $document)
                                <li class="list-group-item">{{ $document->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Étape 3 : الزيارة -->
                <div class="tab-pane fade {{ $currentStep == 3 ? 'show active' : '' }}" id="step3" role="tabpanel">
                    <div class="content-container">
                        <div class="card-body">
                            @include('partials.visite_aff')
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

                        <!-- Bouton de téléchargement -->
                        <a href="{{ route('certificat.download', ['id' => $certificat->id]) }}" class="btn btn-primary">
                            <i class="fas fa-download"></i> تحميل الشهادة
                        </a>
                    </div>
                </div>

            </div>
 </div>
   




 @push('scripts')
<script>
$(document).ready(function() {
    // Défilement fluide vers le contenu lors du changement d'onglet
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
        $('html, body').animate({
            scrollTop: $('.tab-content').offset().top - 80
        }, 500);
    });
    
    // Ajustement dynamique de la hauteur du contenu
    function adjustContentHeight() {
        $('.tab-content').css('min-height', window.innerHeight - $('.wizard-bar').outerHeight() );
    }
    
    adjustContentHeight();
    $(window).resize(adjustContentHeight);
});
</script>
@endpush