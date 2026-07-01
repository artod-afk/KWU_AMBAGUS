<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{
    /**
     * Halaman Penjualan Hari Ini
     */
    public function index()
    {
        $todayTransactions = Transaction::with('items.product')
            ->whereDate('created_at', today())
            ->latest()
            ->get();

        $totalToday    = $todayTransactions->sum('total_amount');
        $totalTrxToday = $todayTransactions->count();

        // Hitung pemasukan bersih: (harga jual - harga beli) × qty per item
        $netIncome = 0;
        foreach ($todayTransactions as $trx) {
            foreach ($trx->items as $item) {
                $product = $item->product;
                if ($product) {
                    $purchasePrice = $product->purchase_price > 0 ? $product->purchase_price : 0;
                    $profit        = ($item->price - $purchasePrice) * $item->quantity;
                    $netIncome    += $profit;
                }
            }
        }

        return view('cashier.index', compact('todayTransactions', 'totalToday', 'totalTrxToday', 'netIncome'));
    }

    /**
     * Halaman Kasir (POS)
     */
    public function pos()
    {
        $products   = Product::with('category')->where('stock', '>', 0)->get();
        $categories = Category::all();
        return view('cashier.pos', compact('products', 'categories'));
    }

    /**
     * Search produk via AJAX
     */
    public function searchProduct(Request $request)
    {
        $search     = $request->search;
        $categoryId = $request->category_id;

        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->get()
            ->map(fn($p) => [
                'id'            => $p->id,
                'name'          => $p->name,
                'stock'         => $p->stock,
                'selling_price' => $p->selling_price > 0 ? $p->selling_price : (is_numeric($p->unit) ? (float)$p->unit : $p->price),
                'unit'          => is_numeric($p->unit) ? 'Pcs' : $p->unit,
                'category'      => $p->category?->name ?? 'Tanpa Kategori',
            ]);

        return response()->json($products);
    }

    /**
     * Proses Checkout
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items'       => 'required|array|min:1',
            'items.*.id'  => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'paid'        => 'required|numeric|min:0',
        ]);

        $items = $request->items;
        $paid  = $request->paid;

        DB::beginTransaction();
        try {
            // Hitung total
            $totalAmount = 0;
            $totalItems  = 0;
            $itemsData   = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['id']);
                $qty     = (int) $item['qty'];

                if ($product->stock < $qty) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$product->name} tidak cukup. Tersedia: {$product->stock}"
                    ], 422);
                }

                $price    = $product->selling_price > 0
                    ? $product->selling_price
                    : (is_numeric($product->unit) ? (float)$product->unit : $product->price);
                $subtotal = $price * $qty;

                $totalAmount += $subtotal;
                $totalItems  += $qty;

                $itemsData[] = [
                    'product'      => $product,
                    'product_name' => $product->name,
                    'price'        => $price,
                    'quantity'     => $qty,
                    'subtotal'     => $subtotal,
                ];
            }

            $change = $paid - $totalAmount;

            if ($change < 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Uang pembayaran kurang!'
                ], 422);
            }

            // Simpan transaksi
            $transaction = Transaction::create([
                'code'          => Transaction::generateCode(),
                'total_amount'  => $totalAmount,
                'paid_amount'   => $paid,
                'change_amount' => $change,
                'total_items'   => $totalItems,
            ]);

            // Simpan item & kurangi stok
            foreach ($itemsData as $data) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $data['product']->id,
                    'product_name'   => $data['product_name'],
                    'price'          => $data['price'],
                    'quantity'       => $data['quantity'],
                    'subtotal'       => $data['subtotal'],
                ]);

                // Kurangi stok
                $data['product']->decrement('stock', $data['quantity']);

                // Catat stock history dengan keterangan penjualan
                StockHistory::log(
                    $data['product']->id,
                    'keluar',
                    $data['quantity'],
                    "Terjual via kasir — Transaksi {$transaction->code}",
                    'sale'
                );
            }

            DB::commit();

            return response()->json([
                'success'     => true,
                'message'     => 'Transaksi berhasil!',
                'transaction' => [
                    'code'    => $transaction->code,
                    'total'   => $totalAmount,
                    'paid'    => $paid,
                    'change'  => $change,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log Transaksi
     */
    public function log(Request $request)
    {
        $query = Transaction::with('items.product');

        if ($request->search) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->paginate(15);

        return view('cashier.log', compact('transactions'));
    }

    /**
     * History Pemasukan Harian — kotor & bersih per hari
     */
    public function incomeHistory(Request $request)
    {
        // Ambil semua transaksi, group by tanggal
        $query = Transaction::with('items.product');

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->latest()->get();

        // Group by tanggal, hitung kotor & bersih per hari
        $dailySummary = $transactions->groupBy(fn($t) => $t->created_at->format('Y-m-d'))
            ->map(function ($dayTrx, $date) {
                $grossIncome = $dayTrx->sum('total_amount');

                // Hitung pemasukan bersih: (harga jual - harga beli) × qty
                $netIncome = 0;
                foreach ($dayTrx as $trx) {
                    foreach ($trx->items as $item) {
                        $product = $item->product;
                        if ($product) {
                            $purchasePrice = $product->purchase_price > 0 ? $product->purchase_price : 0;
                            $netIncome    += ($item->price - $purchasePrice) * $item->quantity;
                        }
                    }
                }

                return [
                    'date'         => $date,
                    'trx_count'    => $dayTrx->count(),
                    'total_items'  => $dayTrx->sum('total_items'),
                    'gross_income' => $grossIncome,
                    'net_income'   => $netIncome,
                    'transactions' => $dayTrx,
                ];
            })
            ->sortKeysDesc();

        // Total keseluruhan
        $totalGross = $dailySummary->sum('gross_income');
        $totalNet   = $dailySummary->sum('net_income');

        return view('cashier.income_history', compact(
            'dailySummary', 'totalGross', 'totalNet'
        ));
    }

    /**
     * Detail Transaksi
     */
    public function detail(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('cashier.detail', compact('transaction'));
    }
}
