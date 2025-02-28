@extends('layouts.app')

@push('content')
<div>
    <h1 class="mt-4 alert alert-info text-center">متابعة طلبك</h1>
    <div class="card shadow-sm mb-4 ">
        <div class="card-body ">
            @include('partials.afficher_certif', ['certificat' => $certificat])
        </div>
    </div>        
    
    @php
        $steps = [
            'step1'=>'0',
            'step2' => '    المستندات والمواعيد',
            'step3' => '   زيارة المنشأة',
            'step4' => '    الشهادة جاهزة'
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
        <!-- Étape 2 : المستندات والمواعيد -->
        <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="step2" role="tabpanel">
            <div class="content-container">
                <div class="alert alert-success">
                    <h3 class="alert-heading">ملاحظة</h3>
                    <p>لإتمام طلبك، يمكنك **تحميل الوثائق مباشرة عبر الإنترنت** من خلال المنصة الإلكترونية المخصصة، أو زيارة مقر الإدارة الجهوية للحماية المدنية أو فرقة الحماية المدنية التابعة للمنطقة التي تقع فيها البناية.</p>
                    <p> نحرص على توفير خيارات متعددة لتسهيل عملية تقديم الطلبات وتلبية احتياجاتكم بأفضل طريقة ممكنة</p>
                </div>
                <form action="{{ route('certificat.uploadDocuments', $certificat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <ul class="list-group">
                        @foreach($certificat->documents as $document)
                            <li class="list-group-item">
                                <div class="mb-2">
                                    <strong>{{ $document->name }}</strong>
                                </div>
                                <div>
                                    <!-- Champ d'upload pour le document -->
                                    <input type="file" name="documents[{{ $document->id }}]" accept=".doc,.docx,.pdf,image/*">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">رفع الوثائق</button>
                    </div>
                </form>
                <div class="card-body">
                    @php
                        // تعريف أسماء الوثائق حسب المعرف
                        $documentNames = [
                            1 => 'بطاقة إرشادات',
                            2 => 'بطاقة التعريف',
                            3 => 'إشهار قانوني مضمون بالنسبة لتأسيس الشخص المعنوي',
                            4 => 'وثيقة تثبت تصرف الطالب في البناية',
                            5 => 'رسم بياني لموقع البناية',
                            6 => 'وصل خالص الإتاوة',
                            7 => 'وثيقة خاصة بالبنايات المعدة للسكن',
                            8 => 'نسخة من قرار الترخيص'
                        ];
                    @endphp

                    <!-- معاينة الوثائق المرفقة -->
                    <div class="uploaded-documents my-4">
                        <h4 class="mt-4 alert alert-info text-center">الوثائق المرفقة:</h4>
                        <div class="row">
                            @foreach($certificat->documents as $document)
                                @if(!empty($document->pivot->path))
                                    @php
                                        $extension = strtolower(pathinfo($document->pivot->path, PATHINFO_EXTENSION));
                                    @endphp
                                    
                                    <div class="col-6 col-sm-6 col-md-3 mb-3">
                                        <div class="card">
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $document->pivot->path) }}" class="card-img-top img-fluid" style="height: 150px; object-fit: cover;" alt="{{ $document->name }}">
                                            @elseif($extension == 'pdf')
                                                <img src="{{ asset('assetslogin/images/pdf.png') }}" class="card-img-top img-fluid" style="height: 150px; object-fit: contain;" alt="رمز PDF">
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <img src="{{ asset('assetslogin/images/word.png') }}" class="card-img-top img-fluid" style="height: 150px; object-fit: contain;" alt="رمز Word">
                                            @else
                                                <div class="card-body text-center">
                                                    <i class="fas fa-file fa-3x"></i>
                                                </div>
                                            @endif
                                            
                                            <!-- اسم الوثيقة -->
                                            <div class="card-body text-center p-2">
                                                <p class="mb-0 small">
                                                    {{ $documentNames[$document->id] ?? $document->name }}
                                                </p>
                                            </div>
                                            
                                            <!-- زر المعاينة -->
                                            <div class="card-footer text-center p-2">
                                                <a href="{{ asset('storage/' . $document->pivot->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    عرض
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

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
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Défilement fluide lors du changement d'onglet
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function() {
        $('html, body').animate({
            scrollTop: $('.tab-content').offset().top - 80
        }, 500);
    });
    
    // Ajustement dynamique de la hauteur du contenu
    function adjustContentHeight() {
        $('.tab-content').css('min-height', window.innerHeight - $('.wizard-bar').outerHeight());
    }
    
    adjustContentHeight();
    $(window).resize(adjustContentHeight);
});
</script>
@endpush
@push('styles')
<style>
    /* Style personnalisé pour la barre d'étapes avec forme de flèche vers la gauche */
    .wizard-bar .nav-pills .nav-link {
        font-size: 1rem;
        padding: 10px 20px;
        text-align: center;
        background: #f8f9fa;
        border: none;
        transition: all 0.2s;
        position: relative;
        /* Forme de flèche vers la gauche */
        clip-path: polygon(40px 0, 100% 0, 100% 100%, 40px 100%, 0 50%);
        -webkit-clip-path: polygon(40px 0, 100% 0, 100% 100%, 40px 100%, 0 50%);
        margin-right: 10px;
    }

    /* Pour l'onglet actif */
    .wizard-bar .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }
</style>
@endpush
