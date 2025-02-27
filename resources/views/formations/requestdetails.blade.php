@extends('layouts.app')

@php
    // Get the authenticated user
    $user = auth()->user();

    // Get the gouver ID from the user
    $gouverId = $user->gouver;

    // Fetch demandes for the formation, filtered by gouvernerat if applicable
    $demandes = $formation->demandes()
                          ->with(['gouvernorat', 'delegation'])
                          ->where('status', 1)
                          ->when($gouverId, function ($query, $gouverId) {
                              return $query->where('gouvernerat', $gouverId);
                          })
                          ->paginate(10);

    // Fetch processed demandes for the formation, filtered by gouvernerat if applicable
    $processedDemandes = $formation->demandes()
                                   ->with(['gouvernorat', 'delegation'])
                                   ->where('status', '!=', 1)
                                   ->when($gouverId, function ($query, $gouverId) {
                                       return $query->where('gouvernerat', $gouverId);
                                   })
                                   ->get();
@endphp

@push('content')
<div class="container py-5" dir="rtl">
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-4">
        <i class="fas fa-arrow-right me-2"></i> العودة
    </a>
    <h2 class="mb-4 text-center">تفاصيل طلبات التكوين - {{ $formation->name }}</h2>

    <div class="mb-4 d-flex gap-2">
        <button id="creerFormationBtn" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> إنشاء التكوين
        </button>
    </div>

    <!-- Formulaire principal -->
    <form id="formationForm" action="{{ route('formation.creation') }}" method="POST">
        @csrf
        <input type="hidden" name="formation_id" value="{{ $formation->id }}">
        <input type="hidden" name="date_prevue" id="datePrevue" value="">

        <!-- Section des demandes actives -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>رقم الملف</th>
                        <th>الولاية</th>
                        <th>المعتمدية</th>
                        <th>تاريخ تقديم الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($demandes as $demande)
                    <tr>
                        <td><input type="checkbox" name="demande_ids[]" value="{{ $demande->id }}" class="demande-checkbox"></td>
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->gouvernorat->name ?? 'غير محدد' }}</td>
                        <td>{{ $demande->delegation->name ?? 'غير محدد' }}</td>
                        <td>{{ $demande->created_at->translatedFormat('j F Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">لا توجد طلبات مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $demandes->links() }}
        </div>
    </form>

    <!-- Section des demandes traitées -->
    <div class="mb-5 border-bottom pb-4">
        <h2 class="mb-4 text-center">الطلبات المعالجة</h4>
        
        <!-- Nouveaux boutons -->
        <div class="mb-3 d-flex gap-2">
            <form id="validerForm" action="{{ route('formations.confirme', $formation) }}" method="POST">
                @csrf
                <button type="button" id="validerDemandes" class="btn btn-success">
                    <i class="fas fa-check me-2"></i> تأكيد الطلبات المحددة
                </button>
            </form>
            <form id="refuserForm" action="{{ route('formations.refuse', $formation) }}" method="POST">
                @csrf
                <button type="button" id="refuserDemandes" class="btn btn-danger">
                    <i class="fas fa-times me-2"></i> رفض الطلبات المحددة
                </button>
            </form>
        </div>

        @if($processedDemandes->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th><input type="checkbox" id="checkAllProcessed"></th>
                        <th>رقم الملف</th>
                        <th>الولاية</th>
                        <th>المعتمدية</th>
                        <th>الحالة</th>
                        <th>التاريخ المحدد</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($processedDemandes as $demande)
                    <tr>
                        <td><input type="checkbox" name="processed_ids[]" value="{{ $demande->id }}" class="processed-checkbox"></td>
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->gouvernorat->name ?? 'غير محدد' }}</td>
                        <td>{{ $demande->delegation->name ?? 'غير محدد' }}</td>
                        <td>
                            @switch($demande->status)
                                @case(2)<span class="badge bg-warning">في انتظار</span>@break
                                @case(3)<span class="badge bg-danger">مرفوض</span>@break
                                @case(4)<span class="badge bg-success">منتهي</span>@break
                                @default<span class="badge bg-secondary">غير معروف</span>
                            @endswitch
                        </td>
                        <td>{{ optional($demande->formationAcceptee)->date_prevue ?? 'يحدد لاحقا' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">لا توجد طلبات معالجة حالياً</div>
        @endif
    </div>
</div>

<!-- Modale pour la sélection de la date prévue -->
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="dateModalLabel">Sélectionner la date prévue</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
            <label for="inputDate" class="form-label">Date prévue :</label>
            <!-- Input de type "date" pour afficher un calendrier -->
            <input type="date" class="form-control" id="inputDate" name="inputDate" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="button" id="saveDateBtn" class="btn btn-primary">Valider</button>
        </div>
        </div>
    </div>
    </div>

@endpush

@push('scripts')
<script>
    // Gestion des checkboxes
    document.getElementById('checkAll').addEventListener('change', function(){
        document.querySelectorAll('.demande-checkbox').forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('checkAllProcessed').addEventListener('change', function(){
        document.querySelectorAll('.processed-checkbox').forEach(cb => cb.checked = this.checked);
    });

    function getSelectedProcessed() {
        return Array.from(document.querySelectorAll('.processed-checkbox:checked'))
                    .map(checkbox => checkbox.value);
    }

    function validateSelection(selected) {
        if(selected.length === 0) {
            alert('الرجاء تحديد طلب واحد على الأقل');
            return false;
        }
        return confirm(`هل أنت متأكد من العملية على ${selected.length} طلب؟`);
    }

        // "Tout sélectionner" : coche/décoche toutes les cases
        document.getElementById('checkAll').addEventListener('change', function(){
        const checkboxes = document.querySelectorAll('.demande-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.getElementById('validerDemandes').addEventListener('click', function() {
    const selected = getSelectedProcessed();
    
    if (validateSelection(selected)) {
        const form = document.getElementById('validerForm');
        
        // Clear any existing hidden inputs
        const existingInputs = form.querySelectorAll('input[name="processed_ids[]"]');
        existingInputs.forEach(input => input.remove());

        // Add new hidden inputs for each selected ID
        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'processed_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        // Submit the form
        form.submit();
    }
});
    // Refus des demandes traitées
document.getElementById('refuserDemandes').addEventListener('click', function() {
    const selected = getSelectedProcessed();
    
    // Log the selected IDs to the console
    console.log('Selected IDs for Refuse:', selected);
    
    if (validateSelection(selected)) {
        const form = document.getElementById('refuserForm');
        
        // Clear any existing hidden inputs
        const existingInputs = form.querySelectorAll('input[name="processed_ids[]"]');
        existingInputs.forEach(input => input.remove());

        // Add new hidden inputs for each selected ID
        selected.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'processed_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        // Submit the form
        form.submit();
    }
});

    // Clic sur le bouton "Créer Formation"
    document.getElementById('creerFormationBtn').addEventListener('click', function(e){
        e.preventDefault();
        const selected = document.querySelectorAll('.demande-checkbox:checked');
        if(selected.length === 0) {
            alert('Merci de choisir parmi ces demandes celles qui concernent cette formation.');
        } else {
            // Affiche la modale pour saisir la date
            var dateModal = new bootstrap.Modal(document.getElementById('dateModal'));
            dateModal.show();
        }
    });

    // Validation de la date dans la modale
    document.getElementById('saveDateBtn').addEventListener('click', function(){
        const inputDate = document.getElementById('inputDate').value;
        if(inputDate){
            document.getElementById('datePrevue').value = inputDate;
            document.getElementById('formationForm').submit();
            alert('Ajouté avec succès dans la formation.');
        } else {
            alert("Veuillez sélectionner une date.");
        }
    });
</script>
@endpush

@push('styles')
<style>
    .table {  border-radius: 0.5rem;    overflow: hidden; }
    .table thead th {  background-color: #0d6efd;   color: white;    border-bottom: 2px solid #dee2e6;}
    .table-hover tbody tr:hover {     background-color: #f8f9fa;}
    .btn-secondary {    background-color: #6c757d;   border-color: #6c757d;  }
    .btn-secondary:hover {    background-color: #5c636a; }
    .btn-success {   background-color: #28a745;    border-color: #28a745; }
    .btn-success:hover {  background-color: #218838; }
    .badge {  padding: 0.5em 0.75em;  font-size: 0.85em;    border-radius: 0.25rem;   }    
    .bg-warning {    background-color: #ffc107 !important; }
    .bg-danger {  background-color: #dc3545 !important;  }
    .bg-success {background-color: #28a745 !important; }
    .table-secondary { background-color: #f8f9fa !important;}
    .processed-checkbox { transform: scale(1.2); margin-right: 8px; }
</style>
@endpush
