<x-app-layout>
    <style>
        .welcome-section {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .menu-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: block;
        }
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.2);
        }
        .menu-card-header {
            padding: 2rem;
            color: white;
        }
        .menu-card-footer {
            background: white;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
        }
        .orange-card { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }
        .green-card  { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
        .orange-text { color: #ea580c; }
        .green-text  { color: #16a34a; }
        .page-bg {
            background: linear-gradient(160deg, #fff7ed 0%, #ffffff 50%, #f0fdf4 100%);
            min-height: 100vh;
        }
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }
        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .grid-4 { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
        }
        .arrow-icon {
            transition: transform 0.3s;
        }
        .menu-card:hover .arrow-icon {
            transform: translateX(6px);
        }
    </style>

    <div class="page-bg">

        <!-- Welcome Section -->
        <div class="welcome-section">
            <div style="max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <h1 style="font-size:2rem; font-weight:700; margin-bottom:0.5rem;">
                        Selamat Datang, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p style="opacity:0.85; font-size:1.1rem;">
                        Kelola stok barang dan transaksi penjualan dengan mudah dalam satu sistem
                    </p>
                </div>
                <div style="opacity:0.3; display:none;" class="hidden md:block">
                    <svg width="100" height="100" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem 3rem;">

            <!-- Statistik Cards -->
            <div class="grid-4">

                <!-- Total Barang -->
                <div class="stat-card" style="border-left: 4px solid #f97316;">
                    <div>
                        <p style="color:#6b7280; font-size:0.85rem; font-weight:500; margin-bottom:0.25rem;">Total Barang</p>
                        <h3 style="font-size:2rem; font-weight:700; color:#1f2937;">{{ \App\Models\Product::count() }}</h3>
                    </div>
                    <div class="stat-icon" style="background:#fff7ed;">
                        <svg width="28" height="28" fill="none" stroke="#f97316" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>

                <!-- Total Stok -->
                <div class="stat-card" style="border-left: 4px solid #3b82f6;">
                    <div>
                        <p style="color:#6b7280; font-size:0.85rem; font-weight:500; margin-bottom:0.25rem;">Total Stok</p>
                        <h3 style="font-size:2rem; font-weight:700; color:#1f2937;">{{ \App\Models\Product::sum('stock') }}</h3>
                    </div>
                    <div class="stat-icon" style="background:#eff6ff;">
                        <svg width="28" height="28" fill="none" stroke="#3b82f6" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>

                <!-- Transaksi Hari Ini -->
                <div class="stat-card" style="border-left: 4px solid #22c55e;">
                    <div>
                        <p style="color:#6b7280; font-size:0.85rem; font-weight:500; margin-bottom:0.25rem;">Transaksi Hari Ini</p>
                        <h3 style="font-size:2rem; font-weight:700; color:#1f2937;">{{ \App\Models\Transaction::whereDate('created_at', today())->count() }}</h3>
                    </div>
                    <div class="stat-icon" style="background:#f0fdf4;">
                        <svg width="28" height="28" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                </div>

                <!-- Stok Menipis -->
                <div class="stat-card" style="border-left: 4px solid #ef4444;">
                    <div>
                        <p style="color:#6b7280; font-size:0.85rem; font-weight:500; margin-bottom:0.25rem;">Stok Menipis</p>
                        <h3 style="font-size:2rem; font-weight:700; color:#1f2937;">{{ \App\Models\Product::whereColumn('stock', '<=', 'minimum_stock')->count() }}</h3>
                    </div>
                    <div class="stat-icon" style="background:#fef2f2;">
                        <svg width="28" height="28" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Menu Cards -->
            <div class="grid-2">

                <!-- Card Stok Barang -->
                <a href="{{ route('products.index') }}" class="menu-card">
                    <div class="menu-card-header orange-card">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                            <h3 style="font-size:1.5rem; font-weight:700;">Stok Barang</h3>
                            <div style="background:rgba(255,255,255,0.2); padding:0.75rem; border-radius:50%;">
                                <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        </div>
                        <p style="opacity:0.85; font-size:0.95rem;">
                            Kelola data barang, kategori, dan persediaan stok
                        </p>
                    </div>
                    <div class="menu-card-footer">
                        <span class="orange-text">Kelola Sekarang</span>
                        <svg class="arrow-icon" width="20" height="20" fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

                <!-- Card Kasir Penjualan -->
                <a href="{{ route('cashier.index') }}" class="menu-card">
                    <div class="menu-card-header green-card">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                            <h3 style="font-size:1.5rem; font-weight:700;">Kasir Penjualan</h3>
                            <div style="background:rgba(255,255,255,0.2); padding:0.75rem; border-radius:50%;">
                                <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p style="opacity:0.85; font-size:0.95rem;">
                            Catat transaksi penjualan dan pemasukan toko
                        </p>
                    </div>
                    <div class="menu-card-footer">
                        <span class="green-text">Buka Kasir</span>
                        <svg class="arrow-icon" width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>

            </div>

            <!-- Footer -->
            <div style="text-align:center; margin-top:3rem; color:#9ca3af; font-size:0.85rem;">
                Sistem Pengelolaan Toko Sembako &copy; {{ date('Y') }}
            </div>

        </div>
    </div>
</x-app-layout>
