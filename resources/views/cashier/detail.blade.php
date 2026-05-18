<x-app-layout>
<style>
    .page { background:linear-gradient(160deg,#0f172a 0%,#1e293b 60%,#0f2027 100%); min-height:100vh; padding:1.5rem; }
    .receipt { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:16px; max-width:520px; margin:0 auto; overflow:hidden; }
    .receipt-header { background:linear-gradient(135deg,#22c55e,#16a34a); padding:1.5rem; text-align:center; }
    .receipt-header h2 { color:white; font-size:1.2rem; font-weight:700; margin-bottom:0.25rem; }
    .receipt-code { font-family:monospace; color:rgba(255,255,255,0.85); font-size:0.9rem; }
    .receipt-body { padding:1.5rem; }
    .receipt-row { display:flex; justify-content:space-between; padding:0.5rem 0; border-bottom:1px solid rgba(255,255,255,0.06); }
    .receipt-row:last-of-type { border-bottom:none; }
    .receipt-row span:first-child { color:rgba(255,255,255,0.5); font-size:0.88rem; }
    .receipt-row span:last-child { color:white; font-weight:600; font-size:0.88rem; }
    .items-table { width:100%; border-collapse:collapse; margin:1rem 0; }
    .items-table th { padding:0.6rem 0; text-align:left; font-size:0.78rem; color:rgba(255,255,255,0.4); text-transform:uppercase; border-bottom:1px solid rgba(255,255,255,0.1); }
    .items-table td { padding:0.6rem 0; font-size:0.88rem; color:rgba(255,255,255,0.8); border-bottom:1px solid rgba(255,255,255,0.05); }
    .items-table tr:last-child td { border-bottom:none; }
    .total-section { background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2); border-radius:10px; padding:1rem; margin-top:1rem; }
    .total-section .receipt-row span:last-child { color:#4ade80; font-size:1rem; }
    .btn-back { display:block; text-align:center; margin-top:1.5rem; background:rgba(255,255,255,0.08); color:rgba(255,255,255,0.7); border:1px solid rgba(255,255,255,0.15); padding:0.7rem; border-radius:8px; text-decoration:none; font-weight:600; }
</style>

<div class="page">
    <div style="max-width:520px; margin:0 auto;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h1 style="color:white; font-size:1.5rem; font-weight:700;">🧾 Detail Transaksi</h1>
            <a href="{{ route('cashier.log') }}" style="color:rgba(255,255,255,0.4); font-size:0.85rem; text-decoration:none;">← Kembali</a>
        </div>

        <div class="receipt">
            <div class="receipt-header">
                <h2>🏪 Toko Sembako</h2>
                <div class="receipt-code">{{ $transaction->code }}</div>
                <div style="color:rgba(255,255,255,0.7); font-size:0.82rem; margin-top:0.25rem;">
                    {{ $transaction->created_at->format('d F Y, H:i') }}
                </div>
            </div>

            <div class="receipt-body">
                <!-- Daftar Barang -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                            <tr>
                                <td>
                                    <div style="color:white; font-weight:500;">{{ $item->product_name }}</div>
                                    <div style="color:rgba(255,255,255,0.4); font-size:0.78rem;">Rp {{ number_format($item->price, 0, ',', '.') }} / satuan</div>
                                </td>
                                <td style="text-align:center; color:#60a5fa; font-weight:600;">{{ $item->quantity }}</td>
                                <td style="text-align:right; color:#4ade80; font-weight:600;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total -->
                <div class="total-section">
                    <div class="receipt-row">
                        <span>Total Item</span>
                        <span>{{ $transaction->total_items }} item</span>
                    </div>
                    <div class="receipt-row">
                        <span style="font-size:1rem; font-weight:700; color:white;">Total Belanja</span>
                        <span style="font-size:1.1rem;">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Uang Dibayar</span>
                        <span style="color:white;">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('cashier.log') }}" class="btn-back">← Kembali ke Log</a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
