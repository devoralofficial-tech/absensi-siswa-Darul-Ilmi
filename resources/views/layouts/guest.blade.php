<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} — Sistem Absensi Siswa</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230d9488'/><path d='M22 22h22v22H22zM56 22h22v22H56zM22 56h22v22H22zM56 60h10v10H56zM68 68h14v14H68zM70 56h12v6H70z' fill='white'/></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: linear-gradient(160deg, #f0fdfa 0%, #ccfbf1 40%, #e0f5f1 100%);
            position: relative;
            overflow: hidden;
        }
        /* Decorative circles */
        .login-page::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(13,148,136,0.12) 0%, transparent 70%);
            top: -150px; right: -150px;
        }
        .login-page::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(45,212,191,0.1) 0%, transparent 70%);
            bottom: -100px; left: -100px;
        }
    </style>
</head>
<body style="background:#f0fdf9">
    <div class="login-page">

        {{-- School Brand --}}
        <div style="text-align:center;margin-bottom:2rem;position:relative;z-index:1">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:72px;height:72px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:22px;margin-bottom:1.125rem;box-shadow:0 8px 28px rgba(13,148,136,0.35)">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    <path d="M14 17h3v3"/><path d="M20 14h-3v3h3"/><path d="M14 14h3"/>
                </svg>
            </div>
            <h1 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.875rem;font-weight:900;color:#0f172a;letter-spacing:-0.03em;margin:0 0 0.3rem">Absensi Siswa</h1>
            <p style="font-size:0.8rem;color:#0d9488;font-weight:600;letter-spacing:0.06em;text-transform:uppercase">QR Code Attendance System</p>
        </div>

        {{-- Card --}}
        <div style="width:100%;max-width:400px;background:white;border-radius:22px;padding:2rem;box-shadow:0 8px 40px rgba(13,148,136,0.12),0 2px 8px rgba(0,0,0,0.05);border:1px solid #e0f5f1;position:relative;z-index:1">

            {{-- Top accent bar --}}
            <div style="position:absolute;top:0;left:2rem;right:2rem;height:3px;background:linear-gradient(90deg,#0d9488,#14b8a6,#2dd4bf);border-radius:0 0 4px 4px"></div>

            {{ $slot }}
        </div>

        <p style="margin-top:1.5rem;font-size:0.75rem;color:#475569;text-align:center;position:relative;z-index:1">
            &copy; {{ date('Y') }} Sistem Absensi Siswa &middot; Powered by QR Code
        </p>
    </div>
</body>
</html>
