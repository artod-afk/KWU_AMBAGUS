<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Income::with('product');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $incomes = $query->latest('transaction_date')->paginate(10);

        return view('finance.incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('finance.incomes.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Hitung total
            $validated['total'] = $validated['quantity'] * $validated['selling_price'];

            // Simpan income
            Income::create($validated);

            // Kurangi stok produk
            $product = Product::findOrFail($validated['product_id']);
            $product->stock -= $validated['quantity'];
            $product->save();

            DB::commit();

            return redirect()->route('incomes.index')
                ->with('success', 'Data pemasukan berhasil ditambahkan dan stok produk telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        return view('finance.incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        $products = Product::all();
        return view('finance.incomes.edit', compact('income', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Kembalikan stok lama
            $product = Product::findOrFail($income->product_id);
            $product->stock += $income->quantity;
            $product->save();

            // Hitung total baru
            $validated['total'] = $validated['quantity'] * $validated['selling_price'];

            // Update income
            $income->update($validated);

            // Kurangi stok baru
            $newProduct = Product::findOrFail($validated['product_id']);
            $newProduct->stock -= $validated['quantity'];
            $newProduct->save();

            DB::commit();

            return redirect()->route('incomes.index')
                ->with('success', 'Data pemasukan berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        DB::beginTransaction();
        try {
            // Kembalikan stok
            $product = Product::findOrFail($income->product_id);
            $product->stock += $income->quantity;
            $product->save();

            // Hapus income
            $income->delete();

            DB::commit();

            return redirect()->route('incomes.index')
                ->with('success', 'Data pemasukan berhasil dihapus dan stok produk telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
