<body dir="rtl">
    <div class="container">
        <h1>الزيارات</h1>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>تاريخ الزيارة</th>
                        <th>الساعة</th>
                        <th>الحالة</th>
                        <th>ملاحظة</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificat->visites as $visite)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($visite->date_visite)->format('Y/m/d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($visite->heure_visite)->format('H') }}</td>
                            <td>
                                @switch($visite->status)
                                    @case(0)
                                        في الانتظار
                                        @break
                                    @case(1)
                                        تمت الموافقة
                                        @break
                                    @case(2)
                                        مرفوضة
                                        @break
                                    @default
                                        غير معروف
                                @endswitch
                            </td>
                            <td>{{ $visite->remarque }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>


<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
        box-sizing: border-box;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    
    /* Adaptation pour les petits écrans */
    @media (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        tr {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
            text-align: right;
        }
        td:before {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: bold;
        }
        td:nth-of-type(1):before { content: "تاريخ الزيارة"; }
        td:nth-of-type(2):before { content: "الساعة"; }
        td:nth-of-type(3):before { content: "الحالة"; }
        td:nth-of-type(4):before { content: "ملاحظة"; }
    }
        /* Adaptation pour les petits écrans - Version améliorée RTL */
        @media (max-width: 768px) {
        table {
            direction: rtl; /* Assurer la cohérence RTL */
        }
        
        table, thead, tbody, th, td, tr {
            display: block;
        }
        
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        
        tr {
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        
        td {
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-right: 50%; /* Modifié de padding-left à padding-right */
            text-align: right;
            min-height: 2em; /* Éviter le chevauchement vertical */
        }
        
        td:before {
            content: attr(data-label); /* Approche plus dynamique */
            position: absolute;
            top: 50%;
            right: 10px; /* Positionnement côté droit pour RTL */
            transform: translateY(-50%);
            width: calc(50% - 20px);
            padding-left: 10px;
            white-space: nowrap;
            font-weight: bold;
            text-align: right;
        }
        
        /* Supprimer la bordure sur le dernier élément */
        td:last-child {
            border-bottom: none;
        }
    }
</style>