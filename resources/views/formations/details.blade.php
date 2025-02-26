<div>
    <h1 class="text-center mb-4 mt-2 ">متابعة الطلب</h1>
    
    @php
    $statuts = [
        1 => '🟡 طلبك قيد الانتظار',
        2 => '🔵 طلبك قيد المعالجة',
        3 => '❌  طلبك مرفوض',
        4 => '✅ تم قبول طلبك',
    ];
        $steps = [
            'step1' => 'تفاصيل الطلب',
            'step2' => 'المستندات والمواعيد',

            'step4' => 'الشهادة جاهزة'
        ];
        $currentStep = $demande->status;
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
                    
                        <div class="card-body">
                            <div id="afficher-demande" class="card p-4" dir="rtl">
                                <p><strong>رقم الملف:</strong> {{ $demande->id }}</p>
                                <p><strong>الولاية:</strong> {{ $gouvernorat ? $gouvernorat->name : 'غير محدد' }}</p>
                                <p><strong>المعتمدية:</strong> {{ $delegation ? $delegation->name : 'غير محدد' }}</p>
                                <p><strong>اسم التكوين:</strong> {{ $formation ? $formation->name : 'غير محدد' }}</p>
                                <p><strong>الحالة:</strong> <span class="fw-bold">{{ $statuts[$demande->status] ?? 'غير محدد' }}</span></p>
                            </div>
                        </div>
                   
                </div>

                <!-- Étape 2 : المستندات والمواعيد -->
                <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" id="step2" role="tabpanel">
                    <div class="content-container">
                        <div class="alert alert-success">
                            <h3 class="alert-heading">ملاحظة</h3>
                            <p class="mb-4">تم قبول طلبكم، يمكنكم بدء التكوين في التاريخ المذكور أعلاه. يرجى إحضار الوثائق الضرورية ومبلغ التكوين.</p>
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