<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <meta charset="UTF-8">
  <title>الشهادة الرسمية</title>
  <style>
    
    /* Custom font with an absolute path */
    @font-face {
      font-family: 'JannaLT';
      font-style: normal;
      font-weight: 300;
      src: url("{{ storage_path('fonts/JannaLTBold.ttf') }}") format('truetype');
    }
    
    html, body {
      direction: rtl;
      /* Removed unicode-bidi: embed; */
      text-align: right;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
    }
    
    body {
      font-family: 'JannaLT', sans-serif;
      line-height: 1.8;
      color: #2d3748;
      background-color: #f8fafc;
      padding: 20px;
    }
    
    .certificate-container {
      background: #fff;
      border: 3px solid #1a365d;
      border-radius: 15px;
      padding: 40px;
      max-width: 800px;
      margin: 0 auto;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      position: relative;
      page-break-inside: avoid;
    }
    
    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #e2e8f0;
      padding-bottom: 20px;
    }
    
    .header h1 {
      color: #1a365d;
      font-size: 32px;
      margin: 0;
      font-weight: bold;
    }
    
    .certificate-body {
      margin: 30px 0;
    }
    
    .details-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .detail-item {
      padding: 15px;
      background: #f8fafc;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
    }
    
    .detail-item strong {
      color: #1a365d;
      display: inline-block;
      min-width: 120px;
    }
    
    .qr-section {
      text-align: center;
      margin-top: 40px;
      padding: 20px;
      background: #f8fafc;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
    }
    
    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-30deg);
      opacity: 0.1;
      font-size: 120px;
      pointer-events: none;
      color: #1a365d;
      z-index: -1;
      white-space: nowrap;
    }
    
    .footer {
      text-align: center;
      margin-top: 30px;
      color: #718096;
      font-size: 14px;
      border-top: 2px solid #e2e8f0;
      padding-top: 20px;
    }
  </style>
</head>
<body>
  <div class="certificate-container">
    
    <div class="header">
      <h1>شهادة وقاية رقمية</h1>
    </div>

    <div class="certificate-body">
      <div class="details-grid">
        <div class="detail-item">
          <strong>رقم الشهادة:</strong> {{ $certificat->id }}
        </div>
        <div class="detail-item">
          <strong>اسم المستخدم:</strong> {{ $certificat->user->name }}
        </div>
        <div class="detail-item">
          <strong>تاريخ الإصدار:</strong> {{ $certificat->formatted_created_at }}
        </div>
        <div class="detail-item">
          <strong>تاريخ الانتهاء:</strong> {{ $certificat->formatted_expiry_at }}
        </div>
        <div class="detail-item">
          <strong>الولاية:</strong> {{ $certificat->gouvernorat_name }}
        </div>
        <div class="detail-item">
          <strong>المندوبية:</strong> {{ $certificat->delegation_name }}
        </div>
        <div class="detail-item">
          <strong>نوع النشاط:</strong> {{ $certificat->type_activite_name }}
        </div>
      </div>

      <div class="qr-section">
        <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code" style="width: 150px; height: 150px;">
        <div style="margin-top: 15px; font-family: monospace; color: #4a5568;">
        </div>
      </div>
    </div>

    <div class="footer">
      <p>هذه الشهادة صادرة إلكترونياً وتعادل الشهادة الرسمية الموقعة</p>
      <p>للتحقق من صحة الشهادة: comming soon</p>
    </div>
  </div>
</body>
</html>
