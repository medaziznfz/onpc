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
        // Si type_activite est 2, utiliser le modèle SpecificActivity
        $activity = SpecificActivity::find($certificat->activity);
        if ($activity) {
            $activityDetails = $activity->name;
        }
    } elseif ($certificat->type_activite == 1) {
        // Si type_activite est 1, utiliser le modèle SpecificActivityErp
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

<div id="afficher-certificat">
    <div class="container">
        <p><strong>رقم الملف :</strong> {{ $certificat->id }}</p>
        <p><strong>الولاية :</strong> {{ $gouvernorat ? $gouvernorat->name : 'غير محددة' }}</p>
        <p><strong>المعتمدية :</strong> {{ $delegation ? $delegation->name : 'غير محددة' }}</p>
        <p><strong>نوع النشاط :</strong> {{ $typesActivites[$certificat->type_activite] ?? 'غير محدد' }}</p>
        <p><strong>تفاصيل النشاط :</strong> {{ $activityDetails }}</p>
        <p><strong>حالة الطلب :</strong> <span class="fw-bold">{{ $statuts[$certificat->statut] ?? 'غير محددة' }}</span></p>
    </div>
</div>



