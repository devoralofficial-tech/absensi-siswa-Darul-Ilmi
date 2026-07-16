<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Siswa</title>
    @vite(['resources/css/app.css'])
    <style>
        @page { size: A4 landscape; margin: 15mm; }
        body { font-family: 'Inter', sans-serif; background: white; }
        .print-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .print-card {
            border: 2px solid #d1fae5;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .print-card img { width: 120px; height: 120px; margin: 0 auto 6px; display: block; image-rendering: pixelated; }
        .print-card .nama { font-weight: 700; font-size: 12px; color: #1f2937; }

        .print-card .token { font-size: 9px; font-family: monospace; color: #16a34a;
                             background: #f0fdf4; border-radius: 6px; padding: 2px 6px; display: inline-block; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { color: #16a34a; font-size: 18px; font-weight: 800; }
        .header p  { color: #6b7280; font-size: 12px; }
        .no-print-btn { margin-bottom: 20px; text-align: center; }
        @media print { .no-print-btn { display: none; } }
    </style>
</head>
<body>
    <div class="no-print-btn">
        <button onclick="window.print()"
                style="background:#16a34a;color:white;border:none;padding:10px 24px;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;">
            🖨 Print Sekarang
        </button>
        <button onclick="window.close()"
                style="margin-left:10px;background:#f3f4f6;color:#374151;border:none;padding:10px 24px;border-radius:10px;font-weight:600;cursor:pointer;font-size:14px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h1>Kartu QR Absensi Siswa</h1>
        <p>{{ config('attendance.school_name') }} — Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="print-grid">
        @foreach($students as $student)
            <div class="print-card">
                @if($student->qr_image_url)
                    <img src="{{ $student->qr_image_url }}" alt="QR {{ $student->nama }}">
                @endif
                <div class="nama">{{ $student->nama }}</div>

                <div class="token">{{ $student->qr_token }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
