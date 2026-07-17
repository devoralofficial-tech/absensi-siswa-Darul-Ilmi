<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Absensi Siswa' }} — Sistem Absensi</title>
    <link rel="icon" type="image/svg+xml"
        href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230d9488'/><path d='M22 22h22v22H22zM56 22h22v22H56zM22 56h22v22H22zM56 60h10v10H56zM68 68h14v14H68zM70 56h12v6H70z' fill='white'/></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background:#f0fdf9;min-height:100vh">

    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="hidden">
        <div style="display:flex;flex-direction:column;align-items:center;gap:1rem">
            <div
                style="width:44px;height:44px;border:3px solid #ccfbf1;border-top-color:#0d9488;border-radius:50%;animation:spinRing 0.75s linear infinite">
            </div>
            <p style="color:#0d9488;font-size:0.875rem;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif">
                Memproses...</p>
        </div>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container"></div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast(@json(session('success')), 'success'));</script>
    @endif
    @if(session('error'))
        <script>document.addEventListener('DOMContentLoaded', () => showToast(@json(session('error')), 'error'));</script>
    @endif

    {{-- ══ SIDEBAR (Desktop) ══ --}}
    <aside class="sidebar no-print">
        {{-- Brand --}}
        <div style="padding:1.25rem;border-bottom:1px solid #e0f5f1">
            <div style="display:flex;align-items:center;gap:0.75rem">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:42px;height:42px;border-radius:50%;object-fit:cover;box-shadow:0 4px 14px rgba(13,148,136,0.35);flex-shrink:0">
                <div>
                    <p
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:0.9rem;color:#0f172a;line-height:1.1">
                        Absensi Siswa - SMP IT Darul Ilmi</p>
                    <p
                        style="font-size:0.65rem;color:#0d9488;font-weight:600;letter-spacing:0.05em;text-transform:uppercase">
                        QR Code System</p>
                </div>
            </div>
        </div>

        {{-- Nav --}}
        <nav style="flex:1;padding:0.875rem;display:flex;flex-direction:column;gap:0.2rem;overflow-y:auto">
            @php
                $navItems = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'scan', 'label' => 'Scan QR', 'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['route' => 'history.index', 'label' => 'Riwayat', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ['route' => 'qr.index', 'label' => 'QR Siswa', 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01'],
                    ['route' => 'report.index', 'label' => 'Laporan', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp

            @foreach($navItems as $item)
                @php $active = request()->routeIs($item['route'] . '*'); @endphp
                <a href="{{ route($item['route']) }}"
                    style="display:flex;align-items:center;gap:0.7rem;padding:0.65rem 0.875rem;border-radius:11px;font-size:0.85rem;font-weight:{{ $active ? '700' : '500' }};font-family:'Plus Jakarta Sans',sans-serif;text-decoration:none;transition:all 0.15s ease;color:{{ $active ? '#0d9488' : '#64748b' }};background:{{ $active ? '#f0fdfa' : 'transparent' }};border:1px solid {{ $active ? '#ccfbf1' : 'transparent' }};"
                    onmouseover="if(!{{ $active ? 'true' : 'false' }}) { this.style.background='#f8fffe'; this.style.color='#0d9488'; }"
                    onmouseout="if(!{{ $active ? 'true' : 'false' }}) { this.style.background='transparent'; this.style.color='#64748b'; }">
                    <div
                        style="width:30px;height:30px;border-radius:8px;background:{{ $active ? 'linear-gradient(135deg,#0d9488,#14b8a6)' : '#f1f5f9' }};display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:{{ $active ? '0 2px 8px rgba(13,148,136,0.3)' : 'none' }}">
                        <svg style="width:15px;height:15px;color:{{ $active ? '#fff' : '#475569' }}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="{{ $active ? '2.3' : '2' }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                    </div>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User --}}
        <div style="padding:1rem;border-top:1px solid #e0f5f1">
            <div
                style="display:flex;align-items:center;gap:0.75rem;margin-bottom:0.75rem;padding:0.75rem;background:#f8fffe;border:1px solid #e0f5f1;border-radius:12px">
                <div
                    style="width:34px;height:34px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:0.875rem;color:white">
                    {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div style="min-width:0;overflow:hidden">
                    <p
                        style="font-size:0.8rem;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Plus Jakarta Sans',sans-serif">
                        {{ auth()->user()->name }}</p>
                    <p style="font-size:0.7rem;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        Berhasil login</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="width:100%;display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.6rem 1rem;font-size:0.8rem;font-weight:600;color:#ef4444;background:white;border:1.5px solid #fecaca;border-radius:9px;cursor:pointer;transition:all 0.15s;font-family:'Plus Jakarta Sans',sans-serif"
                    onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='white'">
                    <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ══ TOP HEADER (Mobile) ══ --}}
    <header class="md:hidden no-print"
        style="position:sticky;top:0;z-index:40;background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);border-bottom:1px solid #e0f5f1;box-shadow:0 2px 10px rgba(13,148,136,0.06)">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1rem">
            <div style="display:flex;align-items:center;gap:0.625rem">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:34px;height:34px;border-radius:50%;object-fit:cover">
                <div>
                    <p
                        style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:0.875rem;color:#0f172a;line-height:1">
                        {{ $title ?? 'Absensi' }}</p>
                    <p
                        style="font-size:0.6rem;color:#0d9488;font-weight:600;text-transform:uppercase;letter-spacing:0.04em">
                        QR System</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;color:#ef4444;background:white;border:1.5px solid #fecaca;border-radius:9px;cursor:pointer">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </header>

    {{-- ══ MAIN ══ --}}
    <main style="min-height:100vh;padding-bottom:5.5rem" class="md:ml-[268px]">
        <div style="padding:1.25rem;max-width:900px;margin:0 auto" class="md:p-7">
            {{ $slot }}
        </div>
    </main>

    {{-- ══ BOTTOM NAV (Mobile) ══ --}}
    <nav class="bottom-nav no-print">
        @php
            $mobileNav = [
                ['route' => 'dashboard', 'label' => 'Home', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'scan', 'label' => 'Scan', 'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route' => 'history.index', 'label' => 'Riwayat', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'qr.index', 'label' => 'QR', 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01'],
                ['route' => 'report.index', 'label' => 'Laporan', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ];
        @endphp
        @foreach($mobileNav as $item)
            @php $active = request()->routeIs($item['route'] . '*'); @endphp
            <a href="{{ route($item['route']) }}" class="bottom-nav-item {{ $active ? 'active' : '' }}">
                <svg style="width:21px;height:21px" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="{{ $active ? '2.3' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
                <span
                    style="font-size:0.6rem;font-weight:{{ $active ? '700' : '500' }};font-family:'Plus Jakarta Sans',sans-serif">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

</body>

</html>