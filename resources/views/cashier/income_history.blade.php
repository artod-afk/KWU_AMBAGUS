<x-app-layout>
<style>
* { box-sizing: border-box; }
.page { background:linear-gradient(160deg,#0f172a 0%,#1e293b 60%,#0f2027 100%); min-height:100vh; padding:1.5rem; }
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
.page-title { font-size:1.5rem; font-weight:700; color:white; }
.btn-back { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7); border:1px solid rgba(255,255,255,0.2); padding:0.5rem 1rem; border-radius:8px; font-size:0.85rem; text-decoration:none; }

/* Filter */
.filter-box { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.5rem; display:flex; gap:0.65rem; flex-wrap:wrap; align-items:flex-end; }
.filter-inp { background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:8px; padding:0.5rem 0.85rem; color:white; font-size:0.85rem; outline:none; font-family:inherit; }
.filter-inp:focus { border-color:#22c55e; }
.btn-filter { background:linear-gradient(135deg,#22c55e,#16a34a); color:white; border:none; padding:0.5rem 1.1rem; border-radius:8px; font-weight:600; font-size:0.85rem; cursor:pointer; font-family:inherit; }
.btn-reset { background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.6); border:1px solid rgba(255,255,255,0.15); padding:0.5rem 0.9rem; border-radius:8px; font-size:0.85rem; text-decoration:none; }

/* Summary total */
.summary-total { display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.75rem; }
.summary-card { border-radius:14px; padding:1.25rem 1.5rem; display:flex; align-items:center; gap:1rem; }
.summary-card.gross { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); }
.summary-card.net   { background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.3); }
.summary-label { font-size:0.8rem; color:rgba(255,255,255,0.5); margin-bottom:0.2rem; }
.summary-value { font-size:1.5rem; font-weight:700; }

/* Daily accordion */
.day-block { background:rgba(255,255,255,0.04); border:1px solid rgba(255,255,255,0.08); border-radius:14px; margin-bottom:1rem; overflow:hidden; }
.day-header { padding:1rem 1.25rem; display:flex; align-items:center; justify-content:space-between; cursor:pointer; flex-wrap:wrap; gap:0.75rem; transition:background 0.2s; }
.day-header:hover { background:rgba(255,255,255,0.04); }
.day-date { color:white; font-weight:700; font-size:0.95rem; }
.day-date-sub { color:rgba(255,255,255,0.4); font-size:0.75rem; margin-top:0.1rem; }
.day-stats { display:flex; gap:1.5rem; flex-wrap:wrap; align-items:center; }
.day-stat { text-align:right; }
.day-stat-label { font-size:0.7rem; color:rgba(255,255,255,0.4); }
.day-stat-value { font-size:0.95rem; font-weight:700; }
.day-toggle { color:rgba(255,255,255,0.4); font-size:1.2rem; transition:transform 0.2s; flex-shrink:0; }
.day-toggle.open { transform:rotate(180deg); }

/* Detail table inside accordion */
.day-detail { display:none; border-top:1px solid rgba(255,255,255,0.06); }
.day-detail.open { display:block; }
.day-detail table { width:100%; border-collapse:collapse; }
.day-detail th { padding:0.65rem 1rem; text-align:left; font-size:0.72rem; font-weight:600; color:rgba(255,255,255,0.4); text-transform:uppercase; background:rgba(0,0,0,0.15); }
.day-detail td { padding:0.65rem 1rem; font-size:0.82rem; color:rgba(255,255,255,0.75); border-bottom:1px solid rgba(255,255,255,0.04); }
.day-detail tr:last-child td { border-bottom:none; }
.trx-code { font-family:monospace; color:#4ade80; font-size:0.8rem; }
.btn-detail-sm { background:rgba(59,130,246,0.2); color:#60a5fa; border:1px solid rgba(59,130,246,0.3); padding:0.2rem 0.65rem; border-radius:5px; font-size:0.72rem; font-weight:600; text-decoration:none; }

/* Gross vs net badge */
.gross-val { color:#4ade80; font-weight:700; }
.net-val   { color:#60a5fa; font-weight:700; }

@media(max-width:640px){
    .summary-total { grid-template-columns:1fr; }
    .day-stats { gap:0.75rem; }
    .page { padding:1rem; }
}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">📊 History Pemasukan Harian</h1>
            <p style="color:rgba(255,255,255,0.4); font-size:0.85rem; margin-top:0.2rem;">Pemasukan kotor & bersih per hari</p>
        </div>
        <a href="{{ route('cashier.index') }}" class="btn-back">← Kembali</a>
    </div>

    <!-- Filter Tanggal -->
    <form method="GET" action="{{ route('cashier.income.history') }}" class="filter-box">
        <div>
            <div style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-bottom:0.3rem;">Dari Tanggal</div>
            <input type="date" name="start_date" class="filter-inp" value="{{ request('start_date') }}">
        </div>
        <div>
            <div style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-bottom:0.3rem;">Sampai Tanggal</div>
            <input type="date" name="end_date" class="filter-inp" value="{{ request('end_date') }}">
        </div>
        <button type="submit" class="btn-filter" style="align-self:flex-end;">Filter</button>
        @if(request()->hasAny(['start_date','end_date']))
            <a href="{{ route('cashier.income.history') }}" class="btn-reset" style="align-self:flex-end;">Reset</a>
        @endif
    </form>

    <!-- Summary Total -->
    <div class="summary-total">
        <div class="summary-card gross">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(34,197,94,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="summary-label">Total Pemasukan Kotor</div>
                <div class="summary-value" style="color:#4ade80;">Rp {{ number_format($totalGross, 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="summary-card net">
            <div style="width:44px;height:44px;border-radius:12px;background:rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="22" height="22" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <div class="summary-label">Total Pemasukan Bersih</div>
                <div class="summary-value" style="color:#60a5fa;">Rp {{ number_format($totalNet, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Daily Accordion -->
    @forelse($dailySummary as $date => $day)
        <div class="day-block">
            <!-- Header hari -->
            <div class="day-header" onclick="toggleDay('day-{{ $loop->index }}')">
                <div>
                    <div class="day-date">{{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}</div>
                    <div class="day-date-sub">{{ $day['trx_count'] }} transaksi · {{ $day['total_items'] }} item terjual</div>
                </div>
                <div class="day-stats">
                    <div class="day-stat">
                        <div class="day-stat-label">Pemasukan Kotor</div>
                        <div class="day-stat-value gross-val">Rp {{ number_format($day['gross_income'], 0, ',', '.') }}</div>
                    </div>
                    <div class="day-stat">
                        <div class="day-stat-label">Pemasukan Bersih</div>
                        <div class="day-stat-value net-val">Rp {{ number_format($day['net_income'], 0, ',', '.') }}</div>
                    </div>
                    <div class="day-toggle" id="chevron-day-{{ $loop->index }}">▼</div>
                </div>
            </div>

            <!-- Detail transaksi per hari -->
            <div class="day-detail" id="day-{{ $loop->index }}">
                <table>
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Waktu</th>
                            <th>Item</th>
                            <th>Pemasukan Kotor</th>
                            <th>Pemasukan Bersih</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($day['transactions'] as $trx)
                            @php
                                // Hitung bersih per transaksi
                                $trxNet = 0;
                                foreach ($trx->items as $item) {
                                    $pp = $item->product?->purchase_price ?? 0;
                                    $trxNet += ($item->price - $pp) * $item->quantity;
                                }
                            @endphp
                            <tr>
                                <td><span class="trx-code">{{ $trx->code }}</span></td>
                                <td>{{ $trx->created_at->format('H:i') }}</td>
                                <td>{{ $trx->total_items }} item</td>
                                <td class="gross-val">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td class="net-val">Rp {{ number_format($trxNet, 0, ',', '.') }}</td>
                                <td><a href="{{ route('cashier.detail', $trx->id) }}" class="btn-detail-sm">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div style="text-align:center; padding:4rem; color:rgba(255,255,255,0.3);">
            <div style="font-size:3rem; margin-bottom:1rem;">📭</div>
            <p>Tidak ada data pemasukan</p>
        </div>
    @endforelse
</div>

<script>
function toggleDay(id) {
    const detail  = document.getElementById(id);
    const chevron = document.getElementById('chevron-' + id);
    const isOpen  = detail.classList.contains('open');
    detail.classList.toggle('open', !isOpen);
    chevron.classList.toggle('open', !isOpen);
}
</script>
</x-app-layout>
