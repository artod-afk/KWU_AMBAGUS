<x-app-layout>
<style>
    .page { background:linear-gradient(160deg,#0f172a 0%,#1e293b 60%,#0f2027 100%); min-height:100vh; padding:1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-size:1.75rem; font-weight:700; color:white; }
    .btn-green { background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.6rem 1.25rem; border-radius:8px; font-weight:600; font-size:0.9rem; text-decoration:none; display:inline-block; }
    .btn-blue { background:rgba(59,130,246,0.2); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.3rem 0.85rem; border-radius:6px; font-size:0.8rem; font-weight:600; text-decoration:none; }
    .filter-box { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.5rem; display:flex; gap:0.75rem; flex-wrap:wrap; align-items:flex-end; }
    .filter-inp { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.55rem 0.9rem; color:white; font-size:0.88rem; outline:none; }
    .filter-inp:focus { border-color:#22c55e; }
    .filter-inp::placeholder { color:rgba(255,255,255,0.3); }
    .btn-filter { background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.55rem 1.25rem; border-radius:8px; font-weight:600; cursor:pointer; font-size:0.88rem; }
    .table-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:14px; overflow:hidden; }
    .table-card table { width:100%; border-collapse:collapse; }
    .table-card thead { background:rgba(34,197,94,0.2); }
    .table-card th { padding:0.85rem 1rem; text-align:left; font-size:0.78rem; font-weight:600; color:rgba(255,255,255,0.7); text-transform:uppercase; }
    .table-card td { padding:0.85rem 1rem; font-size:0.88rem; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.05); }
    .table-card tr:last-child td { border-bottom:none; }
    .table-card tr:hover td { background:rgba(255,255,255,0.03); }
    .trx-code { font-family:monospace; color:#4ade80; font-weight:600; }
</style>

<div class="page">
    <div class="page-header">
        <h1 class="page-title">📋 Log Transaksi</h1>
        <a href="{{ route('cashier.index') }}" class="btn-green">← Kembali</a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('cashier.log') }}" class="filter-box">
        <input type="text" name="search" class="filter-inp" placeholder="🔍 Cari kode transaksi..." value="{{ request('search') }}" style="flex:1; min-width:180px;">
        <input type="date" name="start_date" class="filter-inp" value="{{ request('start_date') }}">
        <input type="date" name="end_date" class="filter-inp" value="{{ request('end_date') }}">
        <button type="submit" class="btn-filter">Filter</button>
        @if(request()->hasAny(['search','start_date','end_date']))
            <a href="{{ route('cashier.log') }}" style="color:rgba(255,255,255,0.5); font-size:0.85rem; align-self:center; text-decoration:none;">Reset</a>
        @endif
    </form>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td><span class="trx-code">{{ $trx->code }}</span></td>
                        <td>{{ $trx->created_at->format('d M Y') }}</td>
                        <td>{{ $trx->created_at->format('H:i') }}</td>
                        <td>{{ $trx->total_items }}</td>
                        <td style="color:#4ade80; font-weight:600;">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trx->paid_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trx->change_amount, 0, ',', '.') }}</td>
                        <td><a href="{{ route('cashier.detail', $trx->id) }}" class="btn-blue">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center; padding:3rem; color:rgba(255,255,255,0.3);">Tidak ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1.25rem;">
        {{ $transactions->links() }}
    </div>
</div>
</x-app-layout>
