<x-app-layout>
    <x-slot:title>Konfirmasi Absensi</x-slot:title>

    <div style="max-width:440px;margin:0 auto" class="fade-in">

        {{-- Page Header --}}
        <div style="text-align:center;margin-bottom:1.5rem">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem;box-shadow:0 6px 20px rgba(13,148,136,0.3)">
                <svg style="width:28px;height:28px" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h2 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.375rem;font-weight:800;color:#0f172a;margin:0 0 0.35rem">Konfirmasi Absensi</h2>
            <p style="font-size:0.825rem;color:#64748b">Periksa data siswa sebelum mencatat kehadiran</p>
        </div>

        {{-- Student Card --}}
        <div class="card" style="margin-bottom:1rem">

            {{-- Student name chip --}}
            <div style="background:linear-gradient(135deg,#f0fdfa,#ccfbf1);border:1px solid #99f6e4;border-radius:14px;padding:0.875rem 1rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.875rem">
                <div style="width:42px;height:42px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:900;font-size:1.125rem;color:white;flex-shrink:0;box-shadow:0 2px 8px rgba(13,148,136,0.3)">
                    {{ mb_strtoupper(mb_substr($student->nama, 0, 1)) }}
                </div>
                <div>
                    <p style="font-size:0.65rem;font-weight:700;color:#0d9488;letter-spacing:0.06em;text-transform:uppercase;margin:0 0 0.2rem">Nama Siswa</p>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1rem;font-weight:800;color:#0f172a;margin:0">{{ $student->nama }}</p>
                </div>
            </div>

            {{-- Info rows --}}
            <div style="display:flex;flex-direction:column;gap:0.5rem;margin-bottom:1rem">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.625rem 0.875rem;background:#f8fffe;border:1px solid #e0f5f1;border-radius:10px">
                    <span style="font-size:0.75rem;font-weight:600;color:#64748b">📱 No. WA Wali</span>
                    <span style="font-size:0.8rem;font-family:'Inter',monospace;color:#334155;font-weight:600">{{ $student->nomor_wa }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.625rem 0.875rem;background:#f8fffe;border:1px solid #e0f5f1;border-radius:10px">
                    <span style="font-size:0.75rem;font-weight:600;color:#64748b">📅 Tanggal</span>
                    <span style="font-size:0.8rem;color:#334155;font-weight:600">{{ $now->locale('id')->isoFormat('D MMMM Y') }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.625rem 0.875rem;background:linear-gradient(135deg,#f0fdfa,#f8fffe);border:1px solid #ccfbf1;border-radius:10px">
                    <span style="font-size:0.75rem;font-weight:600;color:#0d9488">⏰ Jam Saat Ini</span>
                    <span id="clock-time" style="font-size:1rem;font-family:'Plus Jakarta Sans',sans-serif;color:#0d9488;font-weight:800;letter-spacing:0.05em">{{ $now->format('H:i:s') }}</span>
                </div>
            </div>

            @if($isLate)
                <div style="padding:0.75rem 0.875rem;background:#fffbeb;border:1px solid #fde68a;border-radius:10px;display:flex;align-items:center;gap:0.625rem">
                    <svg style="width:17px;height:17px;color:#f59e0b;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p style="font-size:0.8rem;color:#92400e;font-weight:600;margin:0">Perhatian: Siswa sudah melewati jam masuk!</p>
                </div>
            @endif
        </div>

        {{-- Already done warnings --}}
        @if($todayBer && $todayPul)
            <div style="background:#f0fdfa;border:1.5px solid #99f6e4;border-radius:16px;padding:1.125rem;text-align:center;margin-bottom:1rem">
                <div style="width:40px;height:40px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.625rem">
                    <svg style="width:20px;height:20px" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p style="color:#0f766e;font-weight:800;font-size:0.875rem;margin:0;font-family:'Plus Jakarta Sans',sans-serif">Absensi hari ini sudah lengkap!</p>
                <p style="color:#0d9488;font-size:0.775rem;margin-top:0.25rem">Berangkat & Pulang sudah tercatat</p>
            </div>
        @endif

        {{-- Action buttons --}}
        <div id="action-buttons" style="display:flex;flex-direction:column;gap:0.75rem;margin-bottom:0.75rem">
            @unless($todayBer)
                <button onclick="submitAttendance('Berangkat')" id="btn-berangkat" class="btn-primary" style="padding:1rem;font-size:1rem;border-radius:14px;border:none">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Catat BERANGKAT
                </button>
            @else
                <div style="display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:1rem;background:#f0fdfa;border:1.5px solid #99f6e4;border-radius:14px;color:#0d9488;font-weight:700;font-size:0.875rem;font-family:'Plus Jakarta Sans',sans-serif">
                    <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    ✓ Berangkat sudah tercatat
                </div>
            @endunless

            @unless($todayPul)
                <button onclick="submitAttendance('Pulang')" id="btn-pulang" class="btn-secondary" style="padding:1rem;font-size:1rem;border-radius:14px;cursor:pointer;border-color:#93c5fd;color:#3b82f6"
                   onmouseover="this.style.background='#eff6ff';this.style.borderColor='#60a5fa'"
                   onmouseout="this.style.background='white';this.style.borderColor='#93c5fd'">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                    Catat PULANG
                </button>
            @else
                <div style="display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:1rem;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:14px;color:#3b82f6;font-weight:700;font-size:0.875rem;font-family:'Plus Jakarta Sans',sans-serif">
                    <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    ✓ Pulang sudah tercatat
                </div>
            @endunless
        </div>

        {{-- WA Fallback --}}
        <div id="fallback-wa" style="display:none;margin-top:0.875rem;background:#f0fdf9;border:1px solid #bbf7d0;border-radius:14px;padding:1.125rem;text-align:center">
            <p style="font-size:0.8rem;color:#64748b;margin-bottom:0.875rem">Absensi berhasil! Klik tombol di bawah untuk kirim notifikasi ke wali murid.</p>
            <a href="#" id="btn-fallback-wa" target="_blank" class="btn-primary" style="background:linear-gradient(135deg,#16a34a,#22c55e);box-shadow:0 4px 16px rgba(22,163,74,0.3);border-radius:12px;margin-bottom:0.5rem">
                <svg style="width:18px;height:18px" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Kirim Notifikasi WhatsApp
            </a>
            <a href="{{ route('scan') }}" class="btn-secondary" style="border-radius:12px">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Scan Siswa Berikutnya
            </a>
        </div>

        {{-- Back --}}
        <a href="{{ route('scan') }}" id="btn-kembali" class="btn-secondary" style="margin-top:0.5rem">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Scanner
        </a>
    </div>

    <script>
        // Realtime clock
        const serverOffset = new Date('{{ $now->toIso8601String() }}') - new Date();
        setInterval(() => {
            const now = new Date(Date.now() + serverOffset);
            const pad = (n) => String(n).padStart(2, '0');
            const el = document.getElementById('clock-time');
            if (el) el.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
        }, 1000);

        async function submitAttendance(status) {
            if (!navigator.onLine) { showToast('Tidak ada koneksi internet.', 'error'); return; }

            const btnId = status === 'Berangkat' ? 'btn-berangkat' : 'btn-pulang';
            const btn = document.getElementById(btnId);
            if (!btn || btn.disabled) return;

            btn.disabled = true;
            btn.innerHTML = '<span style="display:inline-block;width:18px;height:18px;border:2.5px solid rgba(255,255,255,0.35);border-top-color:white;border-radius:50%;animation:spinRing 0.7s linear infinite"></span> Menyimpan...';
            showLoading();

            let waWindow = null;
            try { waWindow = window.open('', '_blank'); } catch(e) {}

            try {
                const res = await fetch('{{ route('attendance.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ token: '{{ $student->qr_token }}', status }),
                });

                const data = await res.json();
                hideLoading();

                if (!res.ok) {
                    if (waWindow) waWindow.close();
                    showToast(data.message || data.error || 'Terjadi kesalahan.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = status === 'Berangkat'
                        ? '<svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> Catat BERANGKAT'
                        : '<svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg> Catat PULANG';
                    return;
                }

                showToast('Absensi berhasil disimpan!', 'success');
                document.getElementById('action-buttons').style.display = 'none';
                document.getElementById('btn-kembali').style.display = 'none';

                if (waWindow && !waWindow.closed) {
                    waWindow.location = data.wa_link;
                    setTimeout(() => { window.location.href = '{{ route('scan') }}'; }, 1400);
                } else {
                    const fallback = document.getElementById('fallback-wa');
                    fallback.style.display = 'block';
                    document.getElementById('btn-fallback-wa').href = data.wa_link;
                }

            } catch (err) {
                hideLoading();
                if (waWindow) waWindow.close();
                showToast('Gagal menghubungi server.', 'error');
                btn.disabled = false;
            }
        }
    </script>
</x-app-layout>
