<x-app-layout>
<style>
* { box-sizing: border-box; }
.stock-page {
    background: linear-gradient(160deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    min-height: 100vh;
    padding-bottom: 3rem;
}
/* Header bar */
.stock-header-bar {
    background: linear-gradient(135deg, #f97316, #ea580c);
    padding: 1.5rem;
}
.stock-header-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; }
.stock-header-title { color: white; font-size: 1.4rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; }
.stock-header-actions { display: flex; gap: 0.65rem; flex-wrap: wrap; }
.btn-white { background: white; color: #ea580c; border: none; padding: 0.55rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; text-decoration: none; display: inline-block; transition: opacity 0.2s; }
.btn-white:hover { opacity: 0.9; }
.btn-outline-white { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.4); padding: 0.55rem 1.1rem; border-radius: 8px; font-weight: 600; font-size: 0.85rem; cursor: pointer; text-decoration: none; display: inline-block; }

/* Content */
.stock-content { max-width: 1200px; margin: 0 auto; padding: 1.5rem; }

/* Stat grid */
.stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.75rem; }
.stat-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; padding: 1.25rem; display: flex; align-items: center; gap: 0.85rem; transition: transform 0.2s; }
.stat-card:hover { transform: translateY(-3px); }
.stat-icon-box { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.stat-label { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-bottom: 0.2rem; }
.stat-value { font-size: 1.5rem; font-weight: 700; color: white; line-height: 1; }

/* Activity carousel */
.section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem; }
.section-title { color: white; font-size: 0.95rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; }
.btn-sm-link { background: rgba(249,115,22,0.15); color: #fb923c; border: 1px solid rgba(249,115,22,0.3); padding: 0.3rem 0.85rem; border-radius: 7px; font-size: 0.75rem; font-weight: 600; text-decoration: none; }
.carousel-wrap { overflow: hidden; border-radius: 12px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); margin-bottom: 1.75rem; }
.carousel-track { display: flex; gap: 0.75rem; padding: 0.85rem; animation: slideLeft 25s linear infinite; width: max-content; }
.carousel-track:hover { animation-play-state: paused; }
@keyframes slideLeft { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.act-card { background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 0.75rem 1rem; min-width: 220px; flex-shrink: 0; }
.act-icon { font-size: 1.2rem; margin-bottom: 0.3rem; }
.act-label { color: white; font-size: 0.8rem; font-weight: 500; line-height: 1.4; margin-bottom: 0.25rem; }
.act-dot { display: inline-block; width: 7px; height: 7px; border-radius: 50%; margin-right: 0.3rem; vertical-align: middle; }
.act-time { color: rgba(255,255,255,0.35); font-size: 0.7rem; }
.no-activity { color: rgba(255,255,255,0.3); font-size: 0.85rem; padding: 1.5rem; text-align: center; }

/* Main action card */
.main-action-card {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(249,115,22,0.3);
    border-radius: 16px;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
}
.main-action-left { display: flex; align-items: center; gap: 1.25rem; }
.main-action-icon { width: 64px; height: 64px; background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 20px rgba(249,115,22,0.4); }
.main-action-title { color: white; font-size: 1.3rem; font-weight: 700; margin-bottom: 0.3rem; }
.main-action-desc { color: rgba(255,255,255,0.5); font-size: 0.88rem; }
.btn-lihat-stok { background: linear-gradient(135deg, #f97316, #ea580c); color: white; border: none; padding: 0.85rem 2rem; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; text-decoration: none; display: inline-block; box-shadow: 0 4px 15px rgba(249,115,22,0.4); transition: opacity 0.2s, transform 0.2s; white-space: nowrap; }
.btn-lihat-stok:hover { opacity: 0.9; transform: translateY(-2px); }

/* Low stock warning */
.low-stock-section { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 14px; padding: 1.25rem; }
.low-stock-title { color: #f87171; font-size: 0.9rem; font-weight: 700; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.4rem; }
.low-stock-item { display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
.low-stock-item:last-child { border-bottom: none; }
.low-stock-name { color: white; font-size: 0.85rem; font-weight: 500; }
.low-stock-badge { background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 0.15rem 0.6rem; border-radius: 20px; font-size: 0.72rem; font-weight: 600; }

/* Responsive */
@media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px) {
    .stat-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
    .stock-content { padding: 1rem; }
    .main-action-card { padding: 1.25rem; }
    .main-action-icon { width: 50px; height: 50px; }
    .main-action-title { font-size: 1.1rem; }
    .act-card { min-width: 180px; }
}
</style>

<div class="stock-page">

    <!-- Header Bar -->
    <div class="stock-header-bar">
        <div class="stock-header-inner">
            <div class="stock-header-title">
                📦 Stok Barang
            </div>
        </div>
    </div>

    <div class="stock-content">

        <!-- Statistik -->
        <div class="stat-grid" style="margin-top:0.25rem;">
            <div class="stat-card">
                <div class="stat-icon-box" style="background:rgba(249,115,22,0.2);">
                    <svg width="22" height="22" fill="none" stroke="#fb923c" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Barang</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box" style="background:rgba(59,130,246,0.2);">
                    <svg width="22" height="22" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Stok</div>
                    <div class="stat-value">{{ $totalStock }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box" style="background:rgba(139,92,246,0.2);">
                    <svg width="22" height="22" fill="none" stroke="#a78bfa" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Total Kategori</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon-box" style="background:rgba(239,68,68,0.2);">
                    <svg width="22" height="22" fill="none" stroke="#f87171" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-value" style="color:{{ $lowStock > 0 ? '#f87171' : 'white' }}">{{ $lowStock }}</div>
                </div>
            </div>
        </div>

        <!-- Activity Log Carousel -->
        <div class="section-header">
            <div class="section-title">⚡ Riwayat Aktivitas Stok</div>
            <a href="{{ route('stock.history') }}" class="btn-sm-link">Detail Log →</a>
        </div>
        <div class="carousel-wrap">
            @if($activityLogs->count() > 0)
                <div class="carousel-track">
                    @foreach($activityLogs as $log)
                        <div class="act-card">
                            <div class="act-icon">{{ $log['icon'] }}</div>
                            <div class="act-label">
                                <span class="act-dot" style="background:{{ $log['color'] }}"></span>
                                {{ $log['label'] }}
                            </div>
                            <div class="act-time">{{ \Carbon\Carbon::parse($log['time'])->diffForHumans() }}</div>
                        </div>
                    @endforeach
                    {{-- Duplikat untuk seamless loop --}}
                    @foreach($activityLogs as $log)
                        <div class="act-card">
                            <div class="act-icon">{{ $log['icon'] }}</div>
                            <div class="act-label">
                                <span class="act-dot" style="background:{{ $log['color'] }}"></span>
                                {{ $log['label'] }}
                            </div>
                            <div class="act-time">{{ \Carbon\Carbon::parse($log['time'])->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="no-activity">📭 Belum ada aktivitas stok tercatat</div>
            @endif
        </div>

        <!-- Main Action Card -->
        <div class="main-action-card">
            <div class="main-action-left">
                <div class="main-action-icon">
                    <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <div class="main-action-title">Data Stok Barang</div>
                    <div class="main-action-desc">Lihat, edit, tambah, dan hapus data barang beserta harga dan stok</div>
                </div>
            </div>
            <a href="{{ route('products.list') }}" class="btn-lihat-stok">📋 Lihat Stok →</a>
        </div>

        <!-- Stok Menipis Warning -->
        @if($lowStockProducts->count() > 0)
        <div class="low-stock-section">
            <div class="low-stock-title">
                ⚠️ Peringatan Stok Menipis
            </div>
            @foreach($lowStockProducts as $p)
                <div class="low-stock-item">
                    <div>
                        <div class="low-stock-name">{{ $p->name }}</div>
                        <div style="color:rgba(255,255,255,0.4); font-size:0.72rem;">{{ $p->category?->name ?? 'Tanpa Kategori' }}</div>
                    </div>
                    <span class="low-stock-badge">Stok: {{ $p->stock }}</span>
                </div>
            @endforeach
            <div style="margin-top:0.85rem;">
                <a href="{{ route('products.list') }}" style="color:#fb923c; font-size:0.82rem; text-decoration:none;">Lihat semua barang →</a>
            </div>
        </div>
        @endif

    </div>
</div>
</x-app-layout>
