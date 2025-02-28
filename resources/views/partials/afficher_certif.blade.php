@php
    use App\Models\Certificat;
    use App\Models\Governorate;
    use App\Models\Delegation;
    use App\Models\TypeActivite;
    use App\Models\SpecificActivity;
    use App\Models\SpecificActivityErp;

    // Récupérer les informations du gouvernorat et de la délégation
    $gouvernorat = Governorate::find($certificat->gouvernorat);
    $delegation = Delegation::find($certificat->delegation);

    // Récupérer les types d'activités
    $typesActivites = TypeActivite::pluck('nom', 'id')->toArray();

    // Récupérer les détails de l'activité en fonction de type_activite
    $activityDetails = 'غير محدد'; // Valeur par défaut

    if ($certificat->type_activite == 2) {
        $activity = SpecificActivity::find($certificat->activity);
        if ($activity) {
            $activityDetails = $activity->name;
        }
    } elseif ($certificat->type_activite == 1) {
        $activityErp = SpecificActivityErp::find($certificat->activity);
        if ($activityErp) {
            $activityDetails = $activityErp->name;
        }
    }

    // Statuts du certificat
    $statuts = [
        1 => '🟡  طلبك في انتظار المعالجة',
        2 => '🔵  طلبك قيد المعالجة',
        3 => '🔵  طلبك قيد المعالجة',
        4 => '✅  طلبك مقبول',
    ];
@endphp



        <div class="card-body text-center">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>رقم الملف :</strong> {{ $certificat->id }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1">
                        <strong>حالة الطلب :</strong>
                        <span class="fw-bold badge 
                            @if($certificat->statut == 4) bg-success 
                            @elseif($certificat->statut == 2 || $certificat->statut == 3) bg-info 
                            @else bg-warning @endif">
                            {{ $statuts[$certificat->statut] ?? 'غير محددة' }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>الولاية :</strong> {{ $gouvernorat ? $gouvernorat->name : 'غير محددة' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>المعتمدية :</strong> {{ $delegation ? $delegation->name : 'غير محددة' }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>نوع النشاط :</strong> {{ $typesActivites[$certificat->type_activite] ?? 'غير محدد' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>تفاصيل النشاط :</strong> {{ $activityDetails }}</p>
                </div>
            </div>
        </div>
    </div>

