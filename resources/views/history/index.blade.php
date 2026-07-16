<x-app-layout>
    <x-slot:title>Riwayat Absensi</x-slot:title>

    {{-- Header --}}
    <div class="page-header">
        <h2 class="page-title">Riwayat Absensi</h2>
        <p class="page-subtitle">Histori catatan kehadiran siswa</p>
    </div>

    {{-- Filters --}}
    <div class="card" style="margin-bottom:1.25rem">
        <form action="{{ route('history.index') }}" method="GET">
            <div style="display:grid;grid-template-columns:1fr;gap:0.875rem" class="md:grid-cols-4">
                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $filters['tanggal'] ?? '' }}" class="form-input">
                </div>
                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Status</label>
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="Berangkat" {{ ($filters['status'] ?? '') == 'Berangkat' ? 'selected' : '' }}>Berangkat</option>
                        <option value="Pulang" {{ ($filters['status'] ?? '') == 'Pulang' ? 'selected' : '' }}>Pulang</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:0.65rem;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#475569;margin-bottom:0.4rem">Nama Siswa</label>
                    <input type="text" name="nama" value="{{ $filters['nama'] ?? '' }}" placeholder="Cari nama..." class="form-input">
                </div>
                <div style="display:flex;align-items:flex-end;gap:0.5rem">
                    <button type="submit" class="btn-primary" style="padding:0.7rem 1.125rem;font-size:0.825rem;border-radius:12px;border:none;cursor:pointer">
                        <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/></svg>
                        Cari
                    </button>
                    <a href="{{ route('history.index') }}" class="btn-secondary" style="padding:0.7rem 1.125rem;font-size:0.825rem;border-radius:12px">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $index => $att)
                    <tr>
                        <td style="color:#475569;font-size:0.8rem">{{ $attendances->firstItem() + $index }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.625rem">
                                <div style="width:30px;height:30px;border-radius:8px;background:{{ $att->status === 'Berangkat' ? 'rgba(13,148,136,0.15)' : 'rgba(99,102,241,0.15)' }};display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:0.7rem;color:{{ $att->status === 'Berangkat' ? '#2dd4bf' : '#818cf8' }};flex-shrink:0">
                                    {{ mb_strtoupper(mb_substr($att->student->nama ?? '?', 0, 1)) }}
                                </div>
                                <span style="font-weight:600;color:#0f172a">{{ $att->student->nama ?? '-' }}</span>
                            </div>
                        </td>
                        <td style="color:#475569">{{ $att->attendance_date->format('d/m/Y') }}</td>
                        <td style="font-family:'Inter',monospace;color:#64748b;font-size:0.85rem">{{ \Carbon\Carbon::parse($att->attendance_time)->format('H:i') }}</td>
                        <td>
                            <span class="badge {{ $att->status === 'Berangkat' ? 'badge-success' : 'badge-warning' }}">
                                {{ $att->status }}
                            </span>
                        </td>
                        <td>
                            @if($att->is_late)
                                <span class="badge badge-danger">Terlambat {{ $att->late_minutes }}m</span>
                            @else
                                <span class="badge badge-gray">Tepat Waktu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:3.5rem 1rem">
                            <div style="width:52px;height:52px;background:rgba(255,255,255,0.04);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem">
                                <svg style="width:26px;height:26px;color:#334155" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p style="color:#334155;font-size:0.875rem;font-weight:500">Data tidak ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:1rem">
        {{ $attendances->links() }}
    </div>

</x-app-layout>
