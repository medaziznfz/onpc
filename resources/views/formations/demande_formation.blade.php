<div class="container" id="demande-certificat">
    <h2 class="mt-4">إنشاء طلب تكوين</h2>

    <form id="demandeCertificatForm" method="POST" action="{{ route('formation.store') }}">
        @csrf
        
        <!-- الولاية -->
        <div class="form-group">
            <label for="gouvernorat">الولاية:</label>
            <select class="form-control" id="gouvernorat" name="gouvernorat">
                <option value="" selected disabled>اختر الولاية</option>
                @foreach(\App\Models\Governorate::all() as $governorate)
                    <option value="{{ $governorate->id }}" data-code="{{ $governorate->code }}">
                        {{ $governorate->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- المعتمدية -->
        <div class="form-group" id="delegation-container">
            <label for="delegation">المعتمدية:</label>
            <select class="form-control" id="delegation" name="delegation">
                <option value="" selected disabled>اختر المعتمدية</option>
            </select>
        </div>

        <!-- التكوين -->
        <div class="form-group">
            <label for="formation_id">التكوين:</label>
            <select class="form-control" id="formation_id" name="formation_id">
                <option value="" selected disabled>اختر التكوين</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation->id }}">{{ $formation->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">إرسال الطلب</button>
    </form>
</div>


@push('scripts')
<script>


// Lorsque le Gouvernorat est sélectionné, charger les Délégations
$('#gouvernorat').change(function () {
    let governorateId = $(this).val();
    if (governorateId) {
        $.ajax({
            url: '/get-delegations',
            type: 'GET',
            data: { governorate_id: governorateId },
            success: function (data) {
                let delegationSelect = $('#delegation');
                delegationSelect.empty().append('<option value="" selected disabled>اختر المعتمدية</option>');
                $.each(data, function (key, delegation) {
                    delegationSelect.append('<option value="' + delegation.id + '">' + delegation.name + '</option>');
                });
                $('#delegation-container').removeClass('d-none');
            },
            error: function (xhr) {
                console.log("خطأ أثناء تحميل المعتمديات:", xhr);
            }
        });
    } else {
        $('#delegation-container, #activity-type-container').addClass('d-none');
    }
});


</script>
@endpush