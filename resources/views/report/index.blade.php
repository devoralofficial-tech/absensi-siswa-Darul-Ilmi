<x-app-layout>
    <x-slot:title>Laporan Absensi</x-slot:title>

    {{-- Header --}}
    <div class="page-header">
        <h2 class="page-title">Laporan Absensi</h2>
        <p class="page-subtitle">Export data absensi ke format Excel</p>
    </div>

    <div style="max-width:520px;margin:0 auto">
        <div class="card">

            {{-- Icon + Title inside card --}}
            <div style="display:flex;align-items:center;gap:0.875rem;margin-bottom:1.5rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(255,255,255,0.06)">
                <div style="width:44px;height:44px;background:linear-gradient(135deg,rgba(16,185,129,0.2),rgba(13,148,136,0.1));border:1px solid rgba(13,148,136,0.25);border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:22px;height:22px;color:#14b8a6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:0.95rem;font-weight:700;color:#0f172a;margin:0">Export ke Excel</p>
                    <p style="font-size:0.775rem;color:#475569;margin-top:0.2rem">Format .xlsx siap cetak</p>
                </div>
            </div>

            <form action="{{ route('report.export') }}" method="GET" style="display:flex;flex-direction:column;gap:1.125rem">

                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Bulan</label>
                    <select name="bulan" class="form-input">
                        <option value="">Semua Bulan</option>
                        @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ ($filters['bulan'] ?? date('n')) == $num ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Tahun</label>
                    <select name="tahun" class="form-input">
                        @php $currentYear = date('Y'); @endphp
                        @for($y = $currentYear; $y >= $currentYear - 2; $y--)
                            <option value="{{ $y }}" {{ ($filters['tahun'] ?? $currentYear) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Status</label>
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="Berangkat">Berangkat Saja</option>
                        <option value="Pulang">Pulang Saja</option>
                    </select>
                </div>

                <div style="padding-top:0.5rem">
                    <button type="submit" class="btn-primary" style="border:none;cursor:pointer;padding:1rem">
                        <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Excel
                    </button>
                </div>
            </form>
        </div>

        {{-- Info box --}}
        <div style="margin-top:1rem;padding:1rem;background:rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.06);border-radius:14px;display:flex;gap:0.75rem">
            <svg style="width:17px;height:17px;color:#14b8a6;flex-shrink:0;margin-top:0.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p style="font-size:0.775rem;color:#475569;line-height:1.6;margin:0">File Excel berisi 5 kolom: <strong style="color:#64748b">No, Nama, Tanggal, Status, Jam</strong>. Kosongkan filter untuk mengunduh semua data.</p>
        </div>
    </div>

</x-app-layout>
