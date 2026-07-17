<x-guest-layout>
    <x-slot:title>Login</x-slot:title>

    <h2
        style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.25rem;font-weight:800;color:#0f172a;margin:0 0 0.3rem">
        Selamat Datang 👋</h2>
    <p style="font-size:0.825rem;color:#64748b;margin-bottom:1.75rem">Masuk untuk mengakses sistem absensi</p>

    @if(session('status'))
        <div
            style="margin-bottom:1rem;padding:0.75rem 1rem;background:#f0fdfa;border:1px solid #99f6e4;border-radius:10px;font-size:0.825rem;color:#0f766e;font-weight:500">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.125rem">
        @csrf

        <div>
            <label for="email"
                style="display:block;font-size:0.7rem;font-weight:700;color:#64748b;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:0.5rem">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-input"
                placeholder="masukan email">
            @error('email')
                <p style="font-size:0.75rem;color:#ef4444;margin-top:0.35rem;display:flex;align-items:center;gap:0.25rem">
                    <svg style="width:13px;height:13px;flex-shrink:0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="password"
                style="display:block;font-size:0.7rem;font-weight:700;color:#64748b;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:0.5rem">Password</label>
            <input id="password" type="password" name="password" required class="form-input" placeholder="••••••••">
            @error('password')
                <p style="font-size:0.75rem;color:#ef4444;margin-top:0.35rem;display:flex;align-items:center;gap:0.25rem">
                    <svg style="width:13px;height:13px;flex-shrink:0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div style="display:flex;align-items:center;gap:0.5rem">
            <input id="remember" type="checkbox" name="remember"
                style="width:16px;height:16px;border-radius:4px;accent-color:#0d9488;cursor:pointer">
            <label for="remember" style="font-size:0.825rem;color:#64748b;cursor:pointer">Ingat saya</label>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:0.25rem">
            Masuk ke Sistem
        </button>
    </form>
</x-guest-layout>