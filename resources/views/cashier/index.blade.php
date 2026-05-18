<x-app-layout>
<style>
    .page { background:linear-gradient(160deg,#0f172a 0%,#1e293b 60%,#0f2027 100%); min-height:100vh; padding:1.5rem; }
    .page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
    .page-title { font-size:1.75rem; font-weight:700; color:white; }
    .btn-green { background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.75rem 2rem; border-radius:10px; font-weight:700; font-size:1rem; cursor:pointer; text-decoration:none; display:inline-block; transition:opacity 0.2s; box-shadow:0 4px 15px rgba(34,197,94,0.3); }
    .btn-green:hover { opacity:0.9; transform:translateY(-1px); }
    .btn-blue { background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; border:none; padding:0.6rem 1.25rem; border-radius:8px; font-weight:600; font-size:0.9rem; cursor:pointer; text-decoration:none; display:inline-block; }
    .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem; margin-bottom:1.75rem; }
    .stat-card { background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); border-radius:14px; padding:1.5rem; display:flex; align-items:center; gap:1rem; }
    .stat-icon { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-label { font-size:0.8rem; color:rgba(255,255,255,0.5); margin-bottom:0.25rem; }
    .stat-value { font-size:1.6rem; font-weight:700; color:white; }
    .table-card { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:14px; overflow:hidden; }
    .table-card table { width:100%; border-collapse:collapse; }
    .table-card thead { background:rgba(34,197,94,0.2); }
    .table-card th { padding:0.85rem 1rem; text-align:left; font-size:0.78rem; font-weight:600; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.05em; }
    .table-card td { padding:0.85rem 1rem; font-size:0.88rem; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.05); }
    .table-card tr:last-child td { border-bottom:none; }
    .table-card tr:hover td { background:rgba(255,255,255,0.03); }
    .trx-code { font-family:monospace; color:#4ade80; font-weight:600; }
    .empty-state { text-align:center; padding:4rem; color:rgba(255,255,255,0.3); }
    @media(max-width:768px){ .stat-grid{grid-template-columns:1fr;} }
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">🏪 Penjualan Hari Ini</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:0.9rem; margin-top:0.25rem;">{{ now()->format('l, d F Y') }}</p>
        </div>
        <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
            <a href="{{ route('cashier.log') }}" class="btn-blue">📋 Log Transaksi</a>
            <a href="{{ route('cashier.pos') }}" class="btn-green">🛒 Layani Pembeli</a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(34,197,94,0.2);">
                <svg width="26" height="26" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value" style="color:#4ade80;">Rp {{ number_format($totalToday, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Pemasukan Bersih -->
        <div class="stat-card" style="border:1px solid rgba(34,197,94,0.4);">
            <div class="stat-icon" style="background:rgba(34,197,94,0.15);">
                <svg width="26" height="26" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Pemasukan Bersih</div>
                <div style="font-size:0.72rem; color:rgba(255,255,255,0.35); margin-bottom:0.2rem;"></div>
                <div class="stat-value" style="color:{{ $netIncome >= 0 ? '#4ade80' : '#f87171' }};">
                    Rp {{ number_format($netIncome, 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(59,130,246,0.2);">
                <svg width="26" height="26" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value" style="color:#60a5fa;">{{ $totalTrxToday }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:rgba(249,115,22,0.2);">
                <svg width="26" height="26" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Item Terjual</div>
                <div class="stat-value" style="color:#fb923c;">{{ $todayTransactions->sum('total_items') }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi Hari Ini -->
    <div class="table-card">
        <div style="padding:1rem 1.25rem; border-bottom:1px solid rgba(255,255,255,0.08); display:flex; align-items:center; justify-content:space-between;">
            <h2 style="color:white; font-weight:600; font-size:1rem;">Daftar Transaksi Hari Ini</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Waktu</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todayTransactions as $trx)
                    <tr>
                        <td><span class="trx-code">{{ $trx->code }}</span></td>
                        <td>{{ $trx->created_at->format('H:i') }}</td>
                        <td>{{ $trx->total_items }} item</td>
                        <td style="color:#4ade80; font-weight:600;">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trx->paid_amount, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($trx->change_amount, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('cashier.detail', $trx->id) }}" class="btn-blue" style="padding:0.3rem 0.85rem; font-size:0.8rem;">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-state">Belum ada transaksi hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
