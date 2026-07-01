<x-app-layout>
<style>
* { box-sizing: border-box; }
.hist-page { background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; padding: 1.5rem; }
.hist-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
.hist-title { color: white; font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; }
.btn-back { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; }

/* Filter */
.filter-box { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; gap: 0.65rem; flex-wrap: wrap; align-items: flex-end; }
.filter-inp { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; padding: 0.5rem 0.85rem; color: white; font-size: 0.85rem; outline: none; font-family: inherit; }
.filter-inp:focus { border-color: #f97316; }
.filter-inp::placeholder { color: rgba(255,255,255,0.3); }
.filter-inp option { background: #1a1a2e; }
.btn-filter { background: linear-gradient(135deg, #f97316, #ea580c); color: white; border: none; padding: 0.5rem 1.1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; font-family: inherit; }
.btn-reset { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.15); padding: 0.5rem 0.9rem; border-radius: 8px; font-size: 0.85rem; text-decoration: none; }

/* Timeline */
.timeline { position: relative; padding-left: 2rem; }
.timeline::before { content: ''; position: absolute; left: 0.65rem; top: 0; bottom: 0; width: 2px; background: rgba(255,255,255,0.08); }

/* Group by date */
.date-group { margin-bottom: 2rem; }
.date-label { color: rgba(255,255,255,0.4); font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.85rem; padding-left: 0.5rem; }

/* Timeline item */
.tl-item { position: relative; margin-bottom: 0.75rem; }
.tl-dot { position: absolute; left: -1.65rem; top: 0.85rem; width: 14px; height: 14px; border-radius: 50%; border: 2px solid #1a1a2e; flex-shrink: 0; }
.tl-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 0.85rem 1.1rem; transition: border-color 0.2s; }
.tl-card:hover { border-color: rgba(255,255,255,0.18); }
.tl-card.type-masuk { border-left: 3px solid #4ade80; }
.tl-card.type-keluar { border-left: 3px solid #fb923c; }
.tl-card.type-edit-masuk { border-left: 3px solid #60a5fa; }
.tl-card.type-edit-keluar { border-left: 3px solid #c084fc; }
.tl-top { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 0.3rem; }
.tl-product { color: white; font-weight: 600; font-size: 0.9rem; }
.tl-badge { display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.2rem 0.7rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
.badge-masuk { background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }
.badge-keluar { background: rgba(251,146,60,0.15); color: #fb923c; border: 1px solid rgba(251,146,60,0.3); }
.badge-edit { background: rgba(96,165,250,0.15); color: #60a5fa; border: 1px solid rgba(96,165,250,0.3); }
.tl-qty { font-size: 1rem; font-weight: 700; }
.tl-notes { color: rgba(255,255,255,0.45); font-size: 0.78rem; margin-top: 0.2rem; }
.tl-meta { display: flex; align-items: center; gap: 0.75rem; margin-top: 0.35rem; flex-wrap: wrap; }
.tl-time { color: rgba(255,255,255,0.3); font-size: 0.72rem; }
.tl-source { font-size: 0.7rem; padding: 0.1rem 0.5rem; border-radius: 4px; font-weight: 600; }
.src-sale { background: rgba(34,197,94,0.1); color: #4ade80; }
.src-manual-add { background: rgba(249,115,22,0.1); color: #fb923c; }
.src-manual-edit { background: rgba(96,165,250,0.1); color: #60a5fa; }
.src-purchase { background: rgba(192,132,252,0.1); color: #c084fc; }

.empty-state { text-align: center; padding: 4rem; color: rgba(255,255,255,0.3); }
@media (max-width: 640px) {
    .hist-page { padding: 1rem; }
    .filter-box { gap: 0.5rem; }
    .filter-inp { font-size: 0.8rem; }
}
</style>

<div class="hist-page">
    <div class="hist-header">
        <div class="hist-title">📋 Riwayat Stok</div>
        <a href="{{ route('products.index') }}" class="btn-back">← Kembali</a>
    </div>

    <!-- Filter -->
    <form method="GET" action="{{ route('stock.history') }}" class="filter-box">
        <input type="text" name="search" class="filter-inp" placeholder="🔍 Cari nama barang..." value="{{ request('search') }}" style="flex:1; min-width:160px;">
        <select name="type" class="filter-inp">
            <option value="">Semua Tipe</option>
            <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>Masuk</option>
            <option value="keluar" {{ request('type') == 'keluar' ? 'selected' : '' }}>Keluar</option>
        </select>
        <select name="source" class="filter-inp">
            <option value="">Semua Sumber</option>
            <option value="sale" {{ request('source') == 'sale' ? 'selected' : '' }}>Penjualan</option>
            <option value="manual_add" {{ request('source') == 'manual_add' ? 'selected' : '' }}>Tambah Manual</option>
            <option value="manual_edit" {{ request('source') == 'manual_edit' ? 'selected' : '' }}>Edit Manual</option>
        </select>
        <input type="date" name="date" class="filter-inp" value="{{ request('date') }}">
        <button type="submit" class="btn-filter">Filter</button>
        @if(request()->hasAny(['search','type','source','date']))
            <a href="{{ route('stock.history') }}" class="btn-reset">Reset</a>
        @endif
    </form>

    <!-- Timeline -->
    @php
        $grouped = $histories->getCollection()->groupBy(fn($h) => $h->created_at->format('Y-m-d'));
    @endphp

    @if($histories->count() > 0)
        <div class="timeline">
            @foreach($grouped as $date => $items)
                <div class="date-group">
                    <div class="date-label">
                        📅 {{ \Carbon\Carbon::parse($date)->isoFormat('dddd, D MMMM Y') }}
                        <span style="color:rgba(255,255,255,0.25); margin-left:0.5rem;">{{ $items->count() }} aktivitas</span>
                    </div>

                    @foreach($items as $h)
                        @php
                            $isEdit   = str_contains($h->source ?? '', 'edit');
                            $isKeluar = $h->type === 'keluar';
                            $dotColor = $isEdit ? '#60a5fa' : ($isKeluar ? '#fb923c' : '#4ade80');
                            $cardClass = $isEdit
                                ? ($isKeluar ? 'type-edit-keluar' : 'type-edit-masuk')
                                : ($isKeluar ? 'type-keluar' : 'type-masuk');
                            $sourceLabel = match($h->source ?? 'manual_add') {
                                'sale'        => ['label' => 'Penjualan', 'class' => 'src-sale'],
                                'manual_edit' => ['label' => 'Edit Manual', 'class' => 'src-manual-edit'],
                                'purchase'    => ['label' => 'Pembelian', 'class' => 'src-purchase'],
                                default       => ['label' => 'Tambah Manual', 'class' => 'src-manual-add'],
                            };
                        @endphp
                        <div class="tl-item">
                            <div class="tl-dot" style="background:{{ $dotColor }};"></div>
                            <div class="tl-card {{ $cardClass }}">
                                <div class="tl-top">
                                    <div class="tl-product">{{ $h->product?->name ?? 'Produk dihapus' }}</div>
                                    <div style="display:flex; align-items:center; gap:0.5rem;">
                                        @if($isEdit)
                                            <span class="tl-badge badge-edit">✏️ Edit</span>
                                        @elseif($isKeluar)
                                            <span class="tl-badge badge-keluar">↑ Keluar</span>
                                        @else
                                            <span class="tl-badge badge-masuk">↓ Masuk</span>
                                        @endif
                                        <span class="tl-qty" style="color:{{ $dotColor }}">
                                            {{ $isKeluar ? '-' : '+' }}{{ $h->quantity }}
                                        </span>
                                    </div>
                                </div>
                                @if($h->notes)
                                    <div class="tl-notes">{{ $h->notes }}</div>
                                @endif
                                <div class="tl-meta">
                                    <span class="tl-time">🕐 {{ $h->created_at->format('H:i:s') }} — {{ $h->created_at->diffForHumans() }}</span>
                                    <span class="tl-source {{ $sourceLabel['class'] }}">{{ $sourceLabel['label'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div style="margin-top:1.5rem;">
            {{ $histories->links() }}
        </div>
    @else
        <div class="empty-state">
            <div style="font-size:3rem; margin-bottom:1rem;">📭</div>
            <p>Tidak ada riwayat stok ditemukan</p>
        </div>
    @endif
</div>
</x-app-layout>
