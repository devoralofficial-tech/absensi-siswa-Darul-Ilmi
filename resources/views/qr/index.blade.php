<x-app-layout>
    <x-slot:title>QR Siswa</x-slot:title>

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem">
        <div>
            <h2 class="page-title">QR Siswa</h2>
            <p class="page-subtitle">{{ $students->count() }} siswa terdaftar</p>
        </div>
        <div style="display:flex;gap:0.625rem;flex-wrap:wrap">
            <a href="{{ route('qr.print') }}" target="_blank"
               class="btn-secondary" style="width:auto;padding:0.6rem 1rem;font-size:0.8rem;border-radius:12px;gap:0.5rem">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print A4
            </a>
            <a href="{{ route('qr.downloadAll') }}?t={{ time() }}"
               class="btn-primary" style="width:auto;padding:0.6rem 1rem;font-size:0.8rem;border-radius:12px;gap:0.5rem">
                <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                ZIP Semua
            </a>
        </div>
    </div>

    {{-- QR Grid --}}
    <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem" class="sm:grid-cols-3 md:grid-cols-3">
        @foreach($students as $student)
            <div class="card" style="text-align:center;padding:1.25rem;display:flex;flex-direction:column;align-items:center;gap:0.75rem">

                {{-- QR Image --}}
                <div style="padding:0.625rem;background:white;border-radius:12px;display:inline-flex;box-shadow:0 4px 20px rgba(0,0,0,0.3)">
                    @if($student->qr_image_url)
                        <img src="{{ $student->qr_image_url }}" alt="QR {{ $student->nama }}"
                             style="width:110px;height:110px;display:block;image-rendering:pixelated">
                    @else
                        <div style="width:110px;height:110px;display:flex;align-items:center;justify-content:center;background:#f8fafc;color:#475569;font-size:0.7rem">
                            No QR
                        </div>
                    @endif
                </div>

                {{-- Name & Token --}}
                <div>
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:#0f172a;font-size:0.875rem;line-height:1.3;margin:0 0 0.35rem">{{ $student->nama }}</p>
                    <span style="font-size:0.65rem;font-family:'Inter',monospace;font-weight:700;color:#14b8a6;background:rgba(13,148,136,0.1);border:1px solid rgba(13,148,136,0.2);padding:0.2rem 0.5rem;border-radius:999px;letter-spacing:0.04em">
                        {{ $student->qr_token }}
                    </span>
                </div>

                {{-- Download button --}}
                <a href="{{ route('qr.download', $student->id) }}?t={{ time() }}"
                   style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 0.875rem;background:rgba(13,148,136,0.1);border:1px solid rgba(13,148,136,0.2);border-radius:10px;color:#2dd4bf;font-size:0.75rem;font-weight:700;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;transition:all 0.2s"
                   onmouseover="this.style.background='rgba(13,148,136,0.2)'"
                   onmouseout="this.style.background='rgba(13,148,136,0.1)'">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
            </div>
        @endforeach
    </div>

</x-app-layout>
