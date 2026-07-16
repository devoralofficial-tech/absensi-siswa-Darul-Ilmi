<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>

    {{-- Greeting Banner --}}
    <div
        style="background:linear-gradient(135deg,#0d9488 0%,#14b8a6 60%,#2dd4bf 100%);border-radius:20px;padding:1.5rem;margin-bottom:1.5rem;position:relative;overflow:hidden;box-shadow:0 6px 24px rgba(13,148,136,0.3)">
        {{-- Decorative circles --}}
        <div
            style="position:absolute;top:-30px;right:-30px;width:130px;height:130px;border-radius:50%;background:rgba(255,255,255,0.08)">
        </div>
        <div
            style="position:absolute;bottom:-40px;right:60px;width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,0.06)">
        </div>

        <div
            style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;position:relative">
            <div>
                <p
                    style="font-size:0.75rem;color:rgba(255,255,255,0.75);font-weight:600;letter-spacing:0.05em;text-transform:uppercase;margin-bottom:0.35rem">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
                <h2
                    style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.375rem;font-weight:800;color:#ffffff;margin:0;letter-spacing:-0.02em">
                    Assalamualaikum, {{ auth()->user()->name }}! 👋
                </h2>
                <p style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:0.25rem">Sistem absensi berjalan
                    dengan baik</p>
            </div>
            <a href="{{ route('scan') }}"
                style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 1.25rem;background:white;color:#0d9488;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.875rem;border-radius:12px;text-decoration:none;box-shadow:0 2px 10px rgba(0,0,0,0.1);transition:all 0.2s;white-space:nowrap"
                onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(0,0,0,0.15)'"
                onmouseout="this.style.transform='none';this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                <svg style="width:18px;height:18px" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                    <path d="M14 17h3v3" />
                    <path d="M20 14h-3v3h3" />
                    <path d="M14 14h3" />
                </svg>
                Scan QR Sekarang
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:0.875rem;margin-bottom:1.5rem"
        class="md:grid-cols-4">

        <div class="stat-card" style="cursor:default">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f0fdfa,#ccfbf1)">
                    <svg style="width:19px;height:19px;color:#0d9488" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <p
                style="font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:900;color:#0d9488;line-height:1;margin:0">
                {{ $stats['berangkat'] }}</p>
            <p style="font-size:0.75rem;color:#64748b;margin-top:0.3rem;font-weight:600">Berangkat</p>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#0d9488,#2dd4bf);border-radius:0 0 18px 18px">
            </div>
        </div>

        <div class="stat-card" style="cursor:default">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
                <div class="stat-icon" style="background:#eff6ff">
                    <svg style="width:19px;height:19px;color:#3b82f6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                </div>
            </div>
            <p
                style="font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:900;color:#3b82f6;line-height:1;margin:0">
                {{ $stats['pulang'] }}</p>
            <p style="font-size:0.75rem;color:#64748b;margin-top:0.3rem;font-weight:600">Pulang</p>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#3b82f6,#93c5fd);border-radius:0 0 18px 18px">
            </div>
        </div>

        <div class="stat-card" style="cursor:default">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
                <div class="stat-icon" style="background:#fffbeb">
                    <svg style="width:19px;height:19px;color:#f59e0b" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p
                style="font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:900;color:#f59e0b;line-height:1;margin:0">
                {{ max(0, $stats['belumPulang']) }}</p>
            <p style="font-size:0.75rem;color:#64748b;margin-top:0.3rem;font-weight:600">Belum Pulang</p>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f59e0b,#fcd34d);border-radius:0 0 18px 18px">
            </div>
        </div>

        <div class="stat-card" style="cursor:default">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.75rem">
                <div class="stat-icon" style="background:#fff1f2">
                    <svg style="width:19px;height:19px;color:#ef4444" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p
                style="font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:900;color:#ef4444;line-height:1;margin:0">
                {{ $stats['terlambat'] }}</p>
            <p style="font-size:0.75rem;color:#64748b;margin-top:0.3rem;font-weight:600">Terlambat</p>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#ef4444,#fca5a5);border-radius:0 0 18px 18px">
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.125rem">
            <div style="display:flex;align-items:center;gap:0.625rem">
                <div
                    style="width:32px;height:32px;background:linear-gradient(135deg,#f0fdfa,#ccfbf1);border-radius:9px;display:flex;align-items:center;justify-content:center;border:1px solid #99f6e4">
                    <svg style="width:16px;height:16px;color:#0d9488" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3
                    style="font-family:'Plus Jakarta Sans',sans-serif;font-size:0.95rem;font-weight:800;color:#0f172a;margin:0">
                    Riwayat Hari Ini</h3>
            </div>
            <a href="{{ route('history.index') }}"
                style="font-size:0.775rem;font-weight:700;color:#0d9488;text-decoration:none;display:flex;align-items:center;gap:0.2rem;font-family:'Plus Jakarta Sans',sans-serif">
                Lihat semua <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($today->isEmpty())
            <div style="text-align:center;padding:2.5rem 1rem">
                <div
                    style="width:56px;height:56px;background:linear-gradient(135deg,#f0fdfa,#ccfbf1);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem;border:1px solid #99f6e4">
                    <svg style="width:28px;height:28px;color:#5eead4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                    </svg>
                </div>
                <p style="font-size:0.875rem;color:#64748b;font-weight:600;margin:0">Belum ada absensi hari ini</p>
                <p style="font-size:0.775rem;color:#475569;margin-top:0.25rem">Mulai scan QR untuk mencatat kehadiran siswa
                </p>
            </div>
        @else
            <div style="display:flex;flex-direction:column;gap:0.5rem;max-height:320px;overflow-y:auto">
                @foreach($today as $att)
                    <div
                        style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem;background:#f8fffe;border:1px solid #e0f5f1;border-radius:12px">
                        <div style="display:flex;align-items:center;gap:0.75rem">
                            <div
                                style="width:36px;height:36px;border-radius:10px;background:{{ $att->status === 'Berangkat' ? 'linear-gradient(135deg,#f0fdfa,#ccfbf1)' : '#eff6ff' }};border:1px solid {{ $att->status === 'Berangkat' ? '#99f6e4' : '#bfdbfe' }};display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:0.8rem;color:{{ $att->status === 'Berangkat' ? '#0d9488' : '#3b82f6' }};flex-shrink:0">
                                {{ mb_strtoupper(mb_substr($att->student->nama ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <p
                                    style="font-size:0.85rem;font-weight:700;color:#0f172a;margin:0;font-family:'Plus Jakarta Sans',sans-serif">
                                    {{ $att->student->nama ?? '-' }}</p>
                                <p style="font-size:0.7rem;color:#475569;font-family:'Inter',monospace;margin-top:0.1rem">
                                    {{ \Carbon\Carbon::parse($att->attendance_time)->format('H:i') }}</p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            @if($att->is_late)
                                <span class="badge badge-danger">+{{ $att->late_minutes }}m</span>
                            @endif
                            <span class="badge {{ $att->status === 'Berangkat' ? 'badge-success' : 'badge-blue' }}">
                                {{ $att->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>