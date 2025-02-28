@extends('layouts.app')

@push('content')
@php
        $statuts = [
            1 => '🟡 طلبك قيد الانتظار',
            2 => '🔵 طلبك قيد المعالجة',
            3 => '❌  طلبك مرفوض',
            4 => '✅ تم قبول طلبك',
        ];
        $steps = [
            'step1' => '>',
            'step2' => 'المستندات والمواعيد',
            'step4' => 'الشهادة جاهزة'
        ];
        $currentStep = $demande->status;
    @endphp

<div>
    <h1 class="mt-4 alert alert-info text-center">متابعة طلبك</h1>

<!-- Carte d'information initiale avec style amélioré -->
<div class="card shadow-sm mb-4">
    <div class="card-body text-center " dir="rtl">
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>رقم الملف:</strong> {{ $demande->id }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1">
                    <strong>الحالة:</strong>
                    <span class="fw-bold badge 
                            @if($currentStep == 4) bg-success 
                            @elseif($currentStep == 2 || $currentStep == 1) bg-info 
                            @else bg-warning @endif">{{ $statuts[$demande->status] ?? 'غير محدد' }}</span>
                </p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <p class="mb-1"><strong>الولاية:</strong> {{ $gouvernorat ? $gouvernorat->name : 'غير محدد' }}</p>
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>المعتمدية:</strong> {{ $delegation ? $delegation->name : 'غير محدد' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="mb-1 mt-1 alert text-center" style="color:rgb(33, 33, 223);">
                    <strong>اسم التكوين:</strong> {{ $formation ? $formation->name : 'غير محدد' }}
                </p>
            </div>
        </div>
    </div>
</div>
    


    <!-- Navigation du processus avec effet flèche vers la gauche -->
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
                    <p class="mb-4">تم قبول طلبكم، يمكنكم بدء التكوين في التاريخ المذكور أسفله. يرجى إحضار الوثائق الضرورية ومبلغ التكوين.</p>
                </div>    
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>رقم الطلب</th>
                                <th>اسم التكوين</th>
                                <th>الوثائق</th>
                                <th>المدة</th>
                                <th>السعر</th>
                                <th>التاريخ المحدد</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $demande->id }}</td>
                                <td>{{ $formation->name ?? 'غير محدد' }}</td>
                                <td>
                                    @if($formation->document)
                                        @foreach(explode(',', $formation->document) as $doc)
                                            <div class="document-item mb-2">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                {{ trim($doc) }}
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">لا توجد وثائق مطلوبة</span>
                                    @endif
                                </td>
                                <td>{{ $formation->periode }} أسبوع</td>
                                <td>{{ $formation->prix }} دينار</td>
                                <td>{{ optional($demande->formationAcceptee)->date_prevue ?? 'يحدد لاحقا' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Étape 4 : الشهادة جاهزة -->
        <div class="tab-pane fade {{ ($currentStep == 4 || $currentStep == 3) ? 'show active' : '' }}" id="step4" role="tabpanel">

            <div class="content-container text-center py-5">
            @if($demande->status == 4)
                <div class="alert alert-success">
                    <h3 class="alert-heading">الشهادة جاهزة</h3>
                    <p>شهادتك متوفرة وجاهزة للاستلام.</p>
                </div>
            @elseif($demande->status == 3)
                <div class="alert alert-danger">
                    <h3 class="alert-heading">لم تتحصل على شهادة</h3>
                    <p>بعد اجتياز الامتحان، لم تنجح في الحصول على الشهادة. يرجى مراجعة النتائج ومعلومات الاختبار لمعرفة أسباب عدم النجاح.</p>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endpush

@push('styles')
<style>
    /* Style de la navigation en forme de flèche orientée vers la gauche */
    .wizard-bar .nav-pills .nav-link {
        font-size: 1rem;
        padding: 10px 20px;
        text-align: center;
        background: #f8f9fa;
        border: none;
        transition: all 0.2s;
        position: relative;
        clip-path: polygon(40px 0, 100% 0, 100% 100%, 40px 100%, 0 50%);
        -webkit-clip-path: polygon(40px 0, 100% 0, 100% 100%, 40px 100%, 0 50%);
        margin-right: 10px;
    }

    .wizard-bar .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
    }

    /* Ajustements pour le contenu */
    .content-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 15px;
    }
</style>
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
