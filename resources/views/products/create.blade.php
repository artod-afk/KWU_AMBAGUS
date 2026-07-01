<x-app-layout>
<style>
    .page-dark { background:linear-gradient(160deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%); min-height:100vh; padding:1.5rem; }
    .form-card { background:rgba(255,255,255,0.06); border:1px solid rgba(255,165,0,0.2); border-radius:16px; padding:2rem; max-width:680px; margin:0 auto; }
    .form-title { font-size:1.5rem; font-weight:700; color:white; margin-bottom:1.75rem; display:flex; align-items:center; gap:0.5rem; }
    .form-group { margin-bottom:1.25rem; }
    .form-label { display:block; font-size:0.85rem; font-weight:600; color:rgba(255,255,255,0.7); margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.05em; }
    .form-input { width:100%; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.7rem 1rem; color:white; font-size:0.95rem; outline:none; box-sizing:border-box; transition:border-color 0.2s; }
    .form-input:focus { border-color:#f97316; background:rgba(255,255,255,0.12); }
    .form-input::placeholder { color:rgba(255,255,255,0.3); }
    .form-input option { background:#1a1a2e; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .profit-display { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:8px; padding:0.7rem 1rem; color:#4ade80; font-size:0.95rem; font-weight:600; }
    .btn-orange { background:linear-gradient(135deg,#f97316,#ea580c); color:white; border:none; padding:0.75rem 2rem; border-radius:8px; font-weight:700; cursor:pointer; font-size:0.95rem; transition:opacity 0.2s; }
    .btn-orange:hover { opacity:0.85; }
    .btn-gray { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); border:1px solid rgba(255,255,255,0.2); padding:0.75rem 1.5rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.95rem; text-decoration:none; display:inline-block; }
    .error-msg { color:#f87171; font-size:0.8rem; margin-top:0.3rem; }
    .section-divider { border:none; border-top:1px solid rgba(255,255,255,0.1); margin:1.5rem 0; }
    .section-label { font-size:0.75rem; font-weight:700; color:#f97316; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:1rem; }
</style>

<div class="page-dark">
    <div class="form-card">
        <div class="form-title">➕ Tambah Barang Baru</div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <!-- Info Barang -->
            <div class="section-label">Informasi Barang</div>

            <div class="form-group">
                <label class="form-label">Nama Barang *</label>
                <input type="text" name="name" class="form-input" placeholder="Contoh: Mie Sedap Goreng" value="{{ old('name') }}" required>
                @error('name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan *</label>
                    <input type="text" name="unit" class="form-input" placeholder="Pcs / Kg / Dus / Liter / Karton" value="{{ old('unit') }}" required>
                    @error('unit')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Stok Awal *</label>
                    <input type="number" name="stock" class="form-input" placeholder="0" value="{{ old('stock', 0) }}" min="0" required>
                    @error('stock')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok *</label>
                    <input type="number" name="minimum_stock" class="form-input" placeholder="5" value="{{ old('minimum_stock', 5) }}" min="0" required>
                    @error('minimum_stock')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <hr class="section-divider">
            <div class="section-label">Harga Per Satuan</div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga Beli per Satuan (Rp) *</label>
                    <input type="number" name="purchase_price" id="purchase_price" class="form-input"
                           placeholder="Contoh: 24000" value="{{ old('purchase_price', 0) }}"
                           min="0" required oninput="calcProfit()">
                    @error('purchase_price')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Jual per Satuan (Rp) *</label>
                    <input type="number" name="selling_price" id="selling_price" class="form-input"
                           placeholder="Contoh: 26000" value="{{ old('selling_price', 0) }}"
                           min="0" required oninput="calcProfit()">
                    @error('selling_price')<p class="error-msg">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Untung per Satuan</label>
                <div class="profit-display" id="profit-display">Rp 0</div>
            </div>

            <hr class="section-divider">

            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <button type="submit" class="btn-orange">💾 Simpan Barang</button>
                <a href="{{ route('products.list') }}" class="btn-gray">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function calcProfit() {
    const buy  = parseFloat(document.getElementById('purchase_price').value) || 0;
    const sell = parseFloat(document.getElementById('selling_price').value) || 0;
    const profit = sell - buy;
    const el = document.getElementById('profit-display');
    el.textContent = 'Rp ' + profit.toLocaleString('id-ID');
    el.style.color = profit >= 0 ? '#4ade80' : '#f87171';
}
</script>
</x-app-layout>
