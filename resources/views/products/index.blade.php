<x-app-layout>
<style>
    .page-dark { background: linear-gradient(160deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%); min-height:100vh; padding:1.5rem; }
    .search-box { background:rgba(255,255,255,0.07); border:1px solid rgba(255,165,0,0.3); border-radius:12px; padding:1.25rem 1.5rem; margin-bottom:1.5rem; display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end; }
    .search-input { flex:1; min-width:200px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:8px; padding:0.6rem 1rem; color:white; font-size:0.9rem; outline:none; }
    .search-input::placeholder { color:rgba(255,255,255,0.4); }
    .search-input:focus { border-color:#f97316; }
    .select-input { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:8px; padding:0.6rem 1rem; color:white; font-size:0.9rem; outline:none; min-width:160px; }
    .select-input option { background:#1a1a2e; color:white; }
    .btn-orange { background:linear-gradient(135deg,#f97316,#ea580c); color:white; border:none; padding:0.6rem 1.5rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.9rem; text-decoration:none; display:inline-block; transition:opacity 0.2s; }
    .btn-orange:hover { opacity:0.85; }
    .btn-gray { background:rgba(255,255,255,0.15); color:white; border:none; padding:0.6rem 1.2rem; border-radius:8px; font-weight:500; cursor:pointer; font-size:0.9rem; text-decoration:none; display:inline-block; }
    .category-section { margin-bottom:2rem; }
    .category-title { display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem; }
    .category-badge { background:linear-gradient(135deg,#f97316,#ea580c); color:white; padding:0.3rem 1rem; border-radius:20px; font-size:0.8rem; font-weight:700; }
    .category-line { flex:1; height:1px; background:rgba(255,165,0,0.2); }
    .table-wrap { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; overflow:hidden; }
    .table-wrap table { width:100%; border-collapse:collapse; }
    .table-wrap thead { background:rgba(249,115,22,0.8); }
    .table-wrap th { padding:0.85rem 1rem; text-align:left; font-size:0.8rem; font-weight:600; color:white; text-transform:uppercase; letter-spacing:0.05em; }
    .table-wrap td { padding:0.85rem 1rem; font-size:0.88rem; color:rgba(255,255,255,0.85); border-bottom:1px solid rgba(255,255,255,0.06); }
    .table-wrap tr:last-child td { border-bottom:none; }
    .table-wrap tr:hover td { background:rgba(255,255,255,0.04); }
    .badge-aman { background:rgba(34,197,94,0.2); color:#4ade80; border:1px solid rgba(34,197,94,0.3); padding:0.2rem 0.75rem; border-radius:20px; font-size:0.75rem; font-weight:600; }
    .badge-menipis { background:rgba(239,68,68,0.2); color:#f87171; border:1px solid rgba(239,68,68,0.3); padding:0.2rem 0.75rem; border-radius:20px; font-size:0.75rem; font-weight:600; }
    .btn-edit { background:rgba(59,130,246,0.2); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.3rem 0.85rem; border-radius:6px; font-size:0.8rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-edit:hover { background:rgba(59,130,246,0.4); }
    .btn-del { background:rgba(239,68,68,0.2); color:#f87171; border:1px solid rgba(239,68,68,0.3); padding:0.3rem 0.85rem; border-radius:6px; font-size:0.8rem; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-del:hover { background:rgba(239,68,68,0.4); }
    .alert-success { background:rgba(34,197,94,0.15); border:1px solid rgba(34,197,94,0.3); color:#4ade80; padding:0.85rem 1.25rem; border-radius:10px; margin-bottom:1.25rem; }
    .profit-text { color:#4ade80; font-weight:600; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-size:1.75rem; font-weight:700; color:white; }
    .header-actions { display:flex; gap:0.75rem; flex-wrap:wrap; }
</style>

<div class="page-dark">

    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">📦 Stok Barang</h1>
        <div class="header-actions">
            <a href="{{ route('categories.index') }}" class="btn-gray">🏷️ Kelola Kategori</a>
            <a href="{{ route('products.create') }}" class="btn-orange">+ Tambah Barang</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('products.index') }}" class="search-box">
        <input type="text"
               name="search"
               class="search-input"
               placeholder="🔍 Cari nama barang atau kategori..."
               value="{{ request('search') }}">
        <select name="category_id" class="select-input">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-orange">Cari</button>
        @if(request('search') || request('category_id'))
            <a href="{{ route('products.index') }}" class="btn-gray">Reset</a>
        @endif
    </form>

    <!-- Products by Category -->
    @forelse($productsByCategory as $categoryName => $items)
        <div class="category-section">
            <div class="category-title">
                <span class="category-badge">{{ $categoryName }}</span>
                <span style="color:rgba(255,255,255,0.4); font-size:0.8rem;">{{ $items->count() }} barang</span>
                <div class="category-line"></div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Untung</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $product)
                            <tr>
                                <td style="color:white; font-weight:500;">{{ $product->name }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>Rp {{ number_format($product->purchase_price ?? $product->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format(
                                    $product->selling_price > 0
                                        ? $product->selling_price
                                        : (is_numeric($product->unit) ? $product->unit : $product->price),
                                    0, ',', '.'
                                ) }}</td>
                                <td class="profit-text">Rp {{ number_format($product->profit ?? 0, 0, ',', '.') }}</td>
                                <td>{{ is_numeric($product->unit) ? 'Pcs' : $product->unit }}</td>
                                <td>
                                    @if($product->stock <= $product->minimum_stock)
                                        <span class="badge-menipis">Menipis</span>
                                    @else
                                        <span class="badge-aman">Aman</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.5rem;">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn-edit">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-del">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div style="text-align:center; padding:4rem; color:rgba(255,255,255,0.4);">
            <div style="font-size:3rem; margin-bottom:1rem;">📭</div>
            <p style="font-size:1.1rem;">Tidak ada barang ditemukan</p>
            <a href="{{ route('products.create') }}" class="btn-orange" style="margin-top:1rem; display:inline-block;">+ Tambah Barang Pertama</a>
        </div>
    @endforelse

</div>
</x-app-layout>
