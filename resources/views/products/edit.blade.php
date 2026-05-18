<x-app-layout>
<style>
    .page-dark { background:linear-gradient(160deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%); min-height:100vh; padding:1.5rem; }
    .form-card { background:rgba(255,255,255,0.06); border:1px solid rgba(255,165,0,0.2); border-radius:16px; padding:2rem; max-width:680px; margin:0 auto; }
    .form-title { font-size:1.5rem; font-weight:700; color:white; margin-bottom:1.75rem; }
    .form-group { margin-bottom:1.25rem; }
    .form-label { display:block; font-size:0.85rem; font-weight:600; color:rgba(255,255,255,0.7); margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.05em; }
    .form-input { width:100%; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.7rem 1rem; color:white; font-size:0.95rem; outline:none; box-sizing:border-box; transition:border-color 0.2s; }
    .form-input:focus { border-color:#f97316; }
    .form-input option { background:#1a1a2e; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .profit-display { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:8px; padding:0.7rem 1rem; color:#4ade80; font-size:0.95rem; font-weight:600; }
    .btn-orange { background:linear-gradient(135deg,#f97316,#ea580c); color:white; border:none; padding:0.75rem 2rem; border-radius:8px; font-weight:700; cursor:pointer; font-size:0.95rem; }
    .btn-gray { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); border:1px solid rgba(255,255,255,0.2); padding:0.75rem 1.5rem; border-radius:8px; font-weight:600; text-decoration:none; display:inline-block; }
    .error-msg { color:#f87171; font-size:0.8rem; margin-top:0.3rem; }
    .section-divider { border:none; border-top:1px solid rgba(255,255,255,0.1); margin:1.5rem 0; }
    .section-label { font-size:0.75rem; font-weight:700; color:#f97316; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:1rem; }
</style>

<div class="page-dark">
    <div class="form-card">
        <div class="form-title">✏️ Edit Barang</div>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="section-label">Informasi Barang</div>

            <div class="form-group">
                <label class="form-label">Nama Barang *</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $product->name) }}" required>
                @error('name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan *</label>
                    <input type="text" name="unit" class="form-input"
                           value="{{ old('unit', is_numeric($product->unit) ? 'Pcs' : $product->unit) }}"
                           placeholder="Pcs / Kg / Dus / Liter" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Stok *</label>
                    <input type="number" name="stock" class="form-input" value="{{ old('stock', $product->stock) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Minimum Stok *</label>
                    <input type="number" name="minimum_stock" class="form-input" value="{{ old('minimum_stock', $product->minimum_stock) }}" min="0" required>
                </div>
            </div>

            <hr class="section-divider">
            <div class="section-label">Harga Per Satuan</div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga Beli per Satuan (Rp) *</label>
                    <input type="number" name="purchase_price" id="purchase_price" class="form-input"
                           value="{{ old('purchase_price', $product->purchase_price > 0 ? $product->purchase_price : (is_numeric($product->unit) ? $product->unit : 0)) }}"
                           min="0" required oninput="calcProfit()"
                           placeholder="Harga beli 1 satuan">
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Jual per Satuan (Rp) *</label>
                    <input type="number" name="selling_price" id="selling_price" class="form-input"
                           value="{{ old('selling_price', $product->selling_price > 0 ? $product->selling_price : (is_numeric($product->unit) ? $product->unit : 0)) }}"
                           min="0" required oninput="calcProfit()"
                           placeholder="Harga jual 1 satuan">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Untung per Satuan</label>
                <div class="profit-display" id="profit-display">
                    Rp {{ number_format($product->profit ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <hr class="section-divider">

            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <button type="submit" class="btn-orange">💾 Update Barang</button>
                <a href="{{ route('products.index') }}" class="btn-gray">Batal</a>
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
