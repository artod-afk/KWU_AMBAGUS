<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black p-6">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-white">Laporan Keuangan</h1>
            <p class="text-gray-300 mt-2">Ringkasan pemasukan, pengeluaran, dan keuntungan toko</p>
        </div>

        <!-- Filter Tanggal -->
        <div class="bg-gray-800 border border-gray-700 p-4 rounded-lg shadow-xl mb-6">
            <form action="{{ route('finance.report') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="start_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Tanggal Mulai
                    </label>
                    <input type="date" 
                           name="start_date" 
                           id="start_date" 
                           value="{{ $startDate }}"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="end_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Tanggal Akhir
                    </label>
                    <input type="date" 
                           name="end_date" 
                           id="end_date" 
                           value="{{ $endDate }}"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-300 shadow-lg">
                    Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Pemasukan -->
            <div class="bg-gradient-to-br from-green-600 to-green-700 text-white p-6 rounded-xl shadow-2xl border border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2 opacity-90">Total Pemasukan</h2>
                        <p class="text-3xl font-bold">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-gradient-to-br from-red-600 to-red-700 text-white p-6 rounded-xl shadow-2xl border border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2 opacity-90">Total Pengeluaran</h2>
                        <p class="text-3xl font-bold">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Keuntungan -->
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 text-white p-6 rounded-xl shadow-2xl border border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold mb-2 opacity-90">Keuntungan</h2>
                        <p class="text-3xl font-bold">
                            Rp {{ number_format($profit, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <a href="{{ route('incomes.index') }}" 
               class="bg-gray-800 border border-gray-700 p-4 rounded-lg shadow-xl hover:shadow-2xl hover:border-green-500 transition duration-300 flex items-center justify-between group">
                <div>
                    <h3 class="font-semibold text-white group-hover:text-green-400 transition">Lihat Data Pemasukan</h3>
                    <p class="text-sm text-gray-400">Kelola transaksi penjualan</p>
                </div>
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="{{ route('expenses.index') }}" 
               class="bg-gray-800 border border-gray-700 p-4 rounded-lg shadow-xl hover:shadow-2xl hover:border-red-500 transition duration-300 flex items-center justify-between group">
                <div>
                    <h3 class="font-semibold text-white group-hover:text-red-400 transition">Lihat Data Pengeluaran</h3>
                    <p class="text-sm text-gray-400">Kelola transaksi pembelian</p>
                </div>
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Grafik -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-lg shadow-xl mb-6">
            <h2 class="text-xl font-bold mb-4 text-white">Grafik Pemasukan & Pengeluaran</h2>
            <canvas id="financeChart"></canvas>
        </div>

        <!-- Riwayat Transaksi Terbaru -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-bold mb-4 text-white">Riwayat Transaksi Terbaru</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-gray-750">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ \Carbon\Carbon::parse($transaction['date'])->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($transaction['type'] == 'income')
                                        <span class="px-2 py-1 bg-green-900 text-green-300 rounded-full text-xs font-semibold border border-green-700">
                                            Pemasukan
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-900 text-red-300 rounded-full text-xs font-semibold border border-red-700">
                                            Pengeluaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $transaction['product_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $transaction['quantity'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    Rp {{ number_format($transaction['price'], 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $transaction['type'] == 'income' ? 'text-green-400' : 'text-red-400' }}">
                                    Rp {{ number_format($transaction['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                    Tidak ada transaksi dalam periode ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('financeChart');
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: chartData.income,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: chartData.expense,
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#fff'
                        }
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#9ca3af',
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: '#374151'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af'
                        },
                        grid: {
                            color: '#374151'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
