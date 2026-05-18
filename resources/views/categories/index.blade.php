<x-app-layout>
<style>
    .page-dark { background:linear-gradient(160deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%); min-height:100vh; padding:1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-size:1.75rem; font-weight:700; color:white; }
    .btn-orange { background:linear-gradient(135deg,#f97316,#ea580c); color:white; border:none; padding:0.6rem 1.5rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.9rem; text-decoration:none; display:inline-block; }
    .btn-gray { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.8); border:1px solid rgba(255,255,255,0.2); padding:0.6rem 1.2rem; border-radius:8px; font-weight:500; text-decoration:none; display:inline-block; }
    .table-wrap { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; overflow:hidden; }
    .table-wrap table { width:100%; border-collapse:collapse; }
    .table-wrap thead { background:rgba(249,115,22,0.8); }
    .table-wrap th { padding:0.85rem 1rem; text-align:left; font-size:0.8rem; font-weight:600; color:white; text-transform:uppercase; }
    .table-wrap td { padding:0.85rem 1rem; font-size:0.88rem; color:rgba(255,255,255,0.85); border-bottom:1px solid rgba(255,255,255,0.06); }
    .table-wrap tr:last-child td { border-bottom:none; }
    .table-wrap tr:hover td { background:rgba(255,255,255,0.04); }
    .btn-edit { background:rgba(59,130,246,0.2); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.3rem 0.85rem; border-radius:6px; font-size:0.8rem; font-weight:600; text-decoration:none; }
    .btn-del { background:rgba(239,68,68,0.2); color:#f87171; border:1px solid rgba(239,68,68,0.3); padding:0.3rem 0.85rem; border-radius:6px; font-size:0.8rem; font-weight:600; cursor:pointer; }
    .alert-success { background:rgba(34,197,94,0.15); border:1px solid rgba(34,197,94,0.3); color:#4ade80; padding:0.85rem 1.25rem; border-radius:10px; margin-bottom:1.25rem; }
    .count-badge { background:rgba(249,115,22,0.2); color:#fb923c; border:1px solid rgba(249,115,22,0.3); padding:0.2rem 0.75rem; border-radius:20px; font-size:0.75rem; font-weight:600; }
</style>

<div class="page-dark">
    <div class="page-header">
        <h1 class="page-title">🏷️ Kelola Kategori</h1>
        <div style="display:flex; gap:0.75rem;">
            <a href="{{ route('products.index') }}" class="btn-gray">← Kembali ke Stok</a>
            <a href="{{ route('categories.create') }}" class="btn-orange">+ Tambah Kategori</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $i => $category)
                    <tr>
                        <td style="color:rgba(255,255,255,0.4);">{{ $i + 1 }}</td>
                        <td style="color:white; font-weight:600;">{{ $category->name }}</td>
                        <td>{{ $category->description ?? '-' }}</td>
                        <td><span class="count-badge">{{ $category->products_count }} barang</span></td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn-edit">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-del">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:3rem; color:rgba(255,255,255,0.4);">
                            Belum ada kategori. <a href="{{ route('categories.create') }}" style="color:#f97316;">Tambah sekarang</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
