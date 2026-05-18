<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::with('product');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('supplier', 'like', "%{$search}%");
        }

        $expenses = $query->latest('transaction_date')->paginate(10);

        return view('finance.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('finance.expenses.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Hitung total
            $validated['total'] = $validated['quantity'] * $validated['purchase_price'];

            // Simpan expense
            Expense::create($validated);

            // Tambah stok produk
            $product = Product::findOrFail($validated['product_id']);
            $product->stock += $validated['quantity'];
            $product->save();

            DB::commit();

            return redirect()->route('expenses.index')
                ->with('success', 'Data pengeluaran berhasil ditambahkan dan stok produk telah ditambah.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('finance.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $products = Product::all();
        return view('finance.expenses.edit', compact('expense', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Kurangi stok lama
            $product = Product::findOrFail($expense->product_id);
            $product->stock -= $expense->quantity;
            $product->save();

            // Hitung total baru
            $validated['total'] = $validated['quantity'] * $validated['purchase_price'];

            // Update expense
            $expense->update($validated);

            // Tambah stok baru
            $newProduct = Product::findOrFail($validated['product_id']);
            $newProduct->stock += $validated['quantity'];
            $newProduct->save();

            DB::commit();

            return redirect()->route('expenses.index')
                ->with('success', 'Data pengeluaran berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        DB::beginTransaction();
        try {
            // Kurangi stok
            $product = Product::findOrFail($expense->product_id);
            $product->stock -= $expense->quantity;
            $product->save();

            // Hapus expense
            $expense->delete();

            DB::commit();

            return redirect()->route('expenses.index')
                ->with('success', 'Data pengeluaran berhasil dihapus dan stok produk telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
