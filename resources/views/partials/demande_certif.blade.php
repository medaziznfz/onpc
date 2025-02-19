<!-- resources/views/partials/demande-certificat.blade.php -->   
<div id="demande-certificat">
    <h2 class="mt-4">إنشاء طلب شهادة الوقاية</h2>
    <form id="demandeCertificatForm" method="POST" action="{{ route('certificat.submit') }}">
        @csrf

        <!-- Gouvernorat -->
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

        <!-- Délégation -->
        <div class="form-group" id="delegation-container">
            <label for="delegation">المعتمدية:</label>
            <select class="form-control" id="delegation" name="delegation">
                <option value="" selected disabled>اختر المعتمدية</option>
            </select>
        </div>

        <!-- Type d'activité -->
        <div class="form-group" id="activity-type-container">
            <label for="type-activite">طبيعة نشاط المؤسسة:</label>
            <select class="form-control" name="type-activite" id="type-activite">
                <option value="-1">الكل</option>
                @foreach(\App\Models\TypeActivite::all() as $type)
                    <option value="{{ $type->id }}">{{ $type->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Activité spécifique pour type "2" -->
        <div class="form-group d-none" id="specific-activity-dropdown-container">
            <label for="specific-activity">تفاصيل النشاط:</label>
            <select class="form-control" id="specific-activity" name="specific-activity">
                <option value="" disabled selected>اختر نشاطاً</option>
                @foreach(\App\Models\SpecificActivity::all() as $activity)
                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                @endforeach
                <option value="0">أخرى</option>
            </select>
        </div>

        <!-- Activité spécifique ERP pour type "1" -->
        <div class="form-group d-none" id="specific-activity-erp-dropdown-container">
            <label for="specific-activity-erp">تفاصيل النشاط:</label>
            <select class="form-control" id="specific-activity-erp" name="specific-activity-erp">
                <option value="" disabled selected>اختر نشاطاً</option>
                @foreach(\App\Models\SpecificActivityErp::all() as $activity)
                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                @endforeach
                <option value="0">أخرى</option>
            </select>
        </div>

        <!-- Autre activité si sélection "0" -->
        <div class="form-group d-none" id="other-activity-container">
            <label for="other-activity">أدخل تفاصيل النشاط الآخر:</label>
            <input type="text" class="form-control" id="other-activity" name="other-activity" placeholder="أدخل تفاصيل النشاط">
        </div>

        <button type="submit" class="btn btn-success mt-3">إرسال الطلب</button>
    </form>
</div>


