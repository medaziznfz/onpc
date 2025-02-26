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
<div class="container">
    <h2>طلبات التكوين</h2>

    @if($demandes->isEmpty())
        <p>لم يتم العثور على طلبات تكوين.</p>
    @else
        @foreach($demandes as $demande)
            @php
                // Retrieve associated records using the stored IDs
                $gouvernorat = Governorate::find($demande->gouvernerat);
                $delegation   = Delegation::find($demande->delegation);
                $formation    = Formation::find($demande->formation_id);
            @endphp

            <div class="card mb-3">
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
    @endif
</div>
@endpush