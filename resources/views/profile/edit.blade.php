<x-app-layout>
<style>
    .profile-page {
        background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }
    .profile-header {
        max-width: 680px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .profile-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 700;
        flex-shrink: 0;
        box-shadow: 0 4px 15px rgba(249,115,22,0.4);
    }
    .profile-name { color: white; font-size: 1.3rem; font-weight: 700; }
    .profile-email { color: rgba(255,255,255,0.5); font-size: 0.85rem; margin-top: 0.15rem; }
    .profile-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1.75rem;
        max-width: 680px;
        margin: 0 auto 1.25rem;
    }
    .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .card-subtitle {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.4);
        margin-bottom: 1.5rem;
    }
    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        margin-bottom: 0.4rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .form-input {
        width: 100%;
        background: rgba(255,255,255,0.08);
        border: 1.5px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        color: white;
        font-size: 0.95rem;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s;
        font-family: inherit;
    }
    .form-input:focus { border-color: #f97316; background: rgba(255,255,255,0.12); }
    .form-input::placeholder { color: rgba(255,255,255,0.3); }
    .error-msg { color: #f87171; font-size: 0.78rem; margin-top: 0.3rem; }
    .success-msg {
        background: rgba(34,197,94,0.15);
        border: 1px solid rgba(34,197,94,0.3);
        color: #4ade80;
        padding: 0.65rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        margin-bottom: 1.25rem;
    }
    .btn-save {
        background: linear-gradient(135deg, #f97316, #ea580c);
        color: white;
        border: none;
        padding: 0.7rem 1.75rem;
        border-radius: 9px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: opacity 0.2s;
        font-family: inherit;
    }
    .btn-save:hover { opacity: 0.88; }
    .btn-danger {
        background: rgba(239,68,68,0.15);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.3);
        padding: 0.7rem 1.75rem;
        border-radius: 9px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
    }
    .btn-danger:hover { background: rgba(239,68,68,0.3); }
    .divider { border: none; border-top: 1px solid rgba(255,255,255,0.08); margin: 1.25rem 0; }
    @media (max-width: 640px) {
        .profile-page { padding: 1rem; }
        .profile-card { padding: 1.25rem; }
    }
</style>

<div class="profile-page">

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="profile-name">{{ Auth::user()->name }}</div>
            <div class="profile-email">{{ Auth::user()->email }}</div>
        </div>
    </div>

    <!-- Card 1: Update Profile Info -->
    <div class="profile-card">
        <div class="card-title">
            <svg width="18" height="18" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Informasi Profil
        </div>
        <div class="card-subtitle">Perbarui nama dan alamat email akun Anda</div>

        @if (session('status') === 'profile-updated')
            <div class="success-msg">✅ Profil berhasil diperbarui!</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="form-group">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', Auth::user()->name) }}" required>
                @error('name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
        </form>
    </div>

    <!-- Card 2: Update Password -->
    <div class="profile-card">
        <div class="card-title">
            <svg width="18" height="18" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Ubah Password
        </div>
        <div class="card-subtitle">Gunakan password yang panjang dan acak agar lebih aman</div>

        @if (session('status') === 'password-updated')
            <div class="success-msg">✅ Password berhasil diperbarui!</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            <div class="form-group">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-input" autocomplete="current-password">
                @error('current_password', 'updatePassword')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-input" autocomplete="new-password">
                @error('password', 'updatePassword')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="form-input" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-save">🔒 Update Password</button>
        </form>
    </div>

    <!-- Card 3: Delete Account -->
    <div class="profile-card" style="border-color:rgba(239,68,68,0.2);">
        <div class="card-title" style="color:#f87171;">
            <svg width="18" height="18" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus Akun
        </div>
        <div class="card-subtitle">Setelah akun dihapus, semua data akan hilang permanen</div>

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan!')">
            @csrf
            @method('delete')

            <div class="form-group">
                <label class="form-label">Konfirmasi dengan Password</label>
                <input type="password" name="password" class="form-input" placeholder="Masukkan password Anda">
                @error('password', 'userDeletion')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-danger">🗑️ Hapus Akun Saya</button>
        </form>
    </div>

</div>
</x-app-layout>
