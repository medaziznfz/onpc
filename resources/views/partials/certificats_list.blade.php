@if($certificats->isEmpty())
    <div class="alert alert-info text-center">
        لم تقم بإجراء أي طلبات حتى الآن
    </div>
    @include('partials.demande_certif')
@else
    <div class="certificats-list mb-5">
        <h3 class="mb-4">طلباتك السابقة</h3>
        @foreach($certificats as $cert)
            <div class="certificat-card card mb-3 shadow-sm" 
                 data-id="{{ $cert->id }}"
                 onclick="loadCertificatDetails({{ $cert->id }})">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>طلب رقم #{{ $cert->id }}</h5>
                            <span class="badge {{ getStatusBadgeClass($cert->statut) }}">
                                {{ getStatusText($cert->statut) }}
                            </span>
                        </div>
                        <i class="fas fa-chevron-left"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif