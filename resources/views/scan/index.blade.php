<x-app-layout>
    <x-slot:title>Scan QR</x-slot:title>

    <div style="max-width:440px;margin:0 auto">
        {{-- Header --}}
        <div style="text-align:center;margin-bottom:1.5rem">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#0d9488,#14b8a6);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem;box-shadow:0 6px 20px rgba(13,148,136,0.3)">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    <path d="M14 17h3v3"/><path d="M20 14h-3v3h3"/><path d="M14 14h3"/>
                </svg>
            </div>
            <h2 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.375rem;font-weight:800;color:#0f172a;margin:0 0 0.35rem">Scan QR Siswa</h2>
            <p style="font-size:0.825rem;color:#64748b">Arahkan kamera ke QR Code siswa</p>
        </div>

        {{-- Scanner Card --}}
        <div class="card" style="padding:0.875rem;margin-bottom:1rem">
            <div id="qr-reader" style="border-radius:12px;overflow:hidden;width:100%;background:#f8fffe"></div>
            
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.875rem;padding:0 0.5rem">
                <div id="scanner-status" style="font-size:0.825rem;color:#64748b;display:flex;align-items:center;gap:0.5rem;font-weight:500">
                    <div style="width:8px;height:8px;background:#14b8a6;border-radius:50%;animation:pulseDot 1.5s infinite"></div>
                    Memulai kamera...
                </div>
                
                <button id="btn-switch-cam" onclick="switchCamera()" style="display:none;background:#eff6ff;color:#3b82f6;border:1px solid #bfdbfe;border-radius:10px;padding:0.4rem 0.8rem;font-size:0.75rem;font-weight:700;cursor:pointer;align-items:center;gap:0.3rem;font-family:'Plus Jakarta Sans',sans-serif">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    Tukar Kamera
                </button>
            </div>
        </div>

        <div id="scan-error" style="display:none;background:#fff1f2;border:1px solid #fecaca;border-radius:12px;padding:0.875rem;font-size:0.825rem;color:#b91c1c;text-align:center;margin-bottom:1rem"></div>

        <a href="{{ route('dashboard') }}" class="btn-secondary">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <style>
        #qr-reader video { border-radius: 12px !important; }
        #qr-reader__scan_region { border-radius: 12px !important; }
        #qr-reader img[alt="Info icon"] { display: none !important; }
        #qr-reader__dashboard_section_csr button {
            background: linear-gradient(135deg,#0d9488,#14b8a6) !important;
            color: white !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.5rem 1.25rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            margin: 0.5rem auto !important;
            display: block !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        #qr-reader__dashboard_section_swaplink { color: #0d9488 !important; font-weight: 600 !important; }
        #qr-reader select { border: 1.5px solid #ccfbf1 !important; border-radius: 8px !important; color: #334155 !important; }
    </style>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let scanner = null;
        let isProcessing = false;
        let availableCameras = [];
        let currentCamIndex = 0;
        const config = { fps: 10, qrbox: { width: 240, height: 240 }, aspectRatio: 1.0 };
        
        const statusEl = document.getElementById('scanner-status');
        const errorEl  = document.getElementById('scan-error');
        const btnSwitch = document.getElementById('btn-switch-cam');

        function showError(msg) {
            errorEl.textContent = msg;
            errorEl.style.display = 'block';
            setTimeout(() => errorEl.style.display = 'none', 4000);
        }

        function onScanSuccess(decodedText) {
            if (isProcessing) return;
            isProcessing = true;
            if (scanner) scanner.stop().catch(() => {});
            statusEl.innerHTML = '<div style="width:8px;height:8px;background:#f59e0b;border-radius:50%"></div> QR terbaca...';
            const token = decodedText.trim();
            if (!token) { showError('QR tidak valid.'); isProcessing = false; return; }
            window.location.href = `/attendance/confirm/${encodeURIComponent(token)}`;
        }

        function onScanError(err) { /* silent */ }

        function startScannerWithCamera(cameraId) {
            scanner.start(cameraId, config, onScanSuccess, onScanError)
                .then(() => {
                    statusEl.innerHTML = '<div style="width:8px;height:8px;background:#14b8a6;border-radius:50%;animation:pulseDot 1.5s infinite"></div> Kamera aktif';
                })
                .catch(err => { 
                    statusEl.textContent = 'Gagal mengakses kamera.';
                });
        }

        function switchCamera() {
            if (availableCameras.length <= 1) return;
            currentCamIndex = (currentCamIndex + 1) % availableCameras.length;
            if (scanner) {
                statusEl.innerHTML = '<div style="width:8px;height:8px;background:#f59e0b;border-radius:50%"></div> Menukar kamera...';
                scanner.stop().then(() => {
                    startScannerWithCamera(availableCameras[currentCamIndex].id);
                }).catch(() => {
                    startScannerWithCamera(availableCameras[currentCamIndex].id);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            scanner = new Html5Qrcode("qr-reader");

            Html5Qrcode.getCameras().then(cameras => {
                if (!cameras || cameras.length === 0) {
                    statusEl.textContent = 'Kamera tidak ditemukan.';
                    return;
                }
                
                availableCameras = cameras;
                currentCamIndex = cameras.length > 1 ? cameras.length - 1 : 0;
                
                if (cameras.length > 1) {
                    btnSwitch.style.display = 'inline-flex';
                }

                startScannerWithCamera(availableCameras[currentCamIndex].id);
            }).catch(err => {
                statusEl.textContent = 'Izin kamera ditolak.';
            });
        });

        window.addEventListener('beforeunload', () => {
            if (scanner) scanner.stop().catch(() => {});
        });
    </script>
</x-app-layout>
