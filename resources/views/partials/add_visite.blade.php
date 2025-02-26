<div class="add-visite-form">
    <h2>إضافة زيارة</h2>
    <form method="POST" action="{{ route('certificat.visite.store') }}">
        @csrf
        <input type="hidden" name="certificat_id" value="{{ $certificat->id }}">
        <input type="hidden" name="user_id" value="{{ $certificat->user_id }}">

        <div class="form-group">
            <label for="date_visite">تاريخ الزيارة</label>
            <input type="date" id="date_visite" name="date_visite" required>
        </div>

        <div class="form-group">
            <label for="heure_visite">وقت الزيارة</label>
            <input type="time" id="heure_visite" name="heure_visite" required>
        </div>

        <div class="form-group">
            <label for="status">الحالة</label>
            <select name="status" id="status" required>
                <option value="0">في انتظار</option>
                <option value="1">موافق عليه</option>
                <option value="2">مرفوض</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remarque">ملاحظة</label>
            <input type="text" id="remarque" name="remarque" placeholder="أدخل ملاحظة (اختياري)">
        </div>

        <button type="submit" style="text-align: center;">إضافة</button>
    </form>
</div>


<style>
/* النمط العام لنموذج إضافة زيارة */
.add-visite-form {
    margin-top: 40px;
    border: 1px solid #ddd;
    padding: 20px;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.add-visite-form h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.5em;
}

.add-visite-form .form-group {
    margin-bottom: 15px;
}

.add-visite-form .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.add-visite-form .form-group input,
.add-visite-form .form-group select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

.add-visite-form button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

.add-visite-form button:hover {
    background-color: #45a049;
}

@media (max-width: 768px) {
    .add-visite-form {
        padding: 15px;
    }
    .add-visite-form h2 {
        font-size: 1.3em;
    }
    .add-visite-form .form-group input,
    .add-visite-form .form-group select {
        font-size: 0.9em;
    }
    .add-visite-form button {
        font-size: 0.9em;
    }
}
</style>