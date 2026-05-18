<x-app-layout>
<style>
    .page-dark { background:linear-gradient(160deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%); min-height:100vh; padding:1.5rem; }
    .form-card { background:rgba(255,255,255,0.06); border:1px solid rgba(255,165,0,0.2); border-radius:16px; padding:2rem; max-width:520px; margin:0 auto; }
    .form-title { font-size:1.5rem; font-weight:700; color:white; margin-bottom:1.75rem; }
    .form-group { margin-bottom:1.25rem; }
    .form-label { display:block; font-size:0.85rem; font-weight:600; color:rgba(255,255,255,0.7); margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.05em; }
    .form-input { width:100%; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.7rem 1rem; color:white; font-size:0.95rem; outline:none; box-sizing:border-box; }
    .form-input:focus { border-color:#f97316; }
    .form-input::placeholder { color:rgba(255,255,255,0.3); }
    .btn-orange { background:linear-gradient(135deg,#f97316,#ea580c); color:white; border:none; padding:0.75rem 2rem; border-radius:8px; font-weight:700; cursor:pointer; font-size:0.95rem; }
    .btn-gray { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); border:1px solid rgba(255,255,255,0.2); padding:0.75rem 1.5rem; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block; }
    .error-msg { color:#f87171; font-size:0.8rem; margin-top:0.3rem; }
</style>

<div class="page-dark">
    <div class="form-card">
        <div class="form-title">🏷️ Tambah Kategori</div>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Kategori *</label>
                <input type="text" name="name" class="form-input" placeholder="Contoh: Rokok, Minuman, Sembako..." value="{{ old('name') }}" required>
                @error('name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
            </div>

            <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-top:1.5rem;">
                <button type="submit" class="btn-orange">💾 Simpan</button>
                <a href="{{ route('categories.index') }}" class="btn-gray">Batal</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
