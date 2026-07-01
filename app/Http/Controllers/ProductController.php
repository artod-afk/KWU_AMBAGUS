<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Landing page Stok Barang — dashboard dengan activity log & statistik
     */
    public function landing()
    {
        $totalProducts   = Product::count();
        $totalCategories = \App\Models\Category::count();
        $lowStock        = Product::whereColumn('stock', '<=', 'minimum_stock')->count();
        $totalStock      = Product::sum('stock');

        // Activity log stok terbaru
        $activityLogs = StockHistory::with('product')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($log) {
                return [
                    'icon'  => $log->type === 'masuk' ? '📦' : '🛒',
                    'label' => $log->type === 'masuk'
                        ? "Stok masuk: {$log->product?->name} +{$log->quantity}"
                        : "Barang keluar: {$log->product?->name} -{$log->quantity}",
                    'time'  => $log->created_at,
                    'color' => $log->type === 'masuk' ? '#4ade80' : '#fb923c',
                ];
            });

        // Stok menipis untuk ditampilkan
        $lowStockProducts = Product::whereColumn('stock', '<=', 'minimum_stock')
            ->with('category')->take(5)->get();

        return view('products.landing', compact(
            'totalProducts', 'totalCategories', 'lowStock',
            'totalStock', 'activityLogs', 'lowStockProducts'
        ));
    }

    /**
     * Tabel daftar stok barang (halaman lama)
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryFilter = $request->category_id;

        $products = Product::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->when($categoryFilter, function ($query) use ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            })
            ->get();

        // Kelompokkan berdasarkan kategori
        $productsByCategory = $products->groupBy(function ($product) {
            return $product->category ? $product->category->name : 'Tanpa Kategori';
        });

        $categories = Category::all();

        return view('products.index', compact('products', 'productsByCategory', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'stock'          => 'required|integer|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'unit'           => 'required|string|max:50',
        ]);

        $profit = $request->selling_price - $request->purchase_price;

        $product = Product::create([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'stock'          => $request->stock,
            'minimum_stock'  => $request->minimum_stock,
            'price'          => $request->selling_price, // price = harga jual (kompatibel lama)
            'purchase_price' => $request->purchase_price,
            'selling_price'  => $request->selling_price,
            'profit'         => $profit,
            'unit'           => $request->unit,
        ]);

        StockHistory::log(
            $product->id,
            'masuk',
            $request->stock,
            "Produk baru ditambahkan dengan stok awal {$request->stock}",
            'manual_add'
        );

        return redirect()->route('products.list')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'stock'          => 'required|integer|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'unit'           => 'required|string|max:50',
        ]);

        $profit = $request->selling_price - $request->purchase_price;

        // Catat perubahan stok jika berbeda
        $oldStock  = $product->stock;
        $newStock  = (int) $request->stock;
        $stockDiff = $newStock - $oldStock;

        $product->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'stock'          => $newStock,
            'minimum_stock'  => $request->minimum_stock,
            'price'          => $request->selling_price,
            'purchase_price' => $request->purchase_price,
            'selling_price'  => $request->selling_price,
            'profit'         => $profit,
            'unit'           => $request->unit,
        ]);

        // Catat history jika stok berubah
        if ($stockDiff !== 0) {
            $type  = $stockDiff > 0 ? 'masuk' : 'keluar';
            $qty   = abs($stockDiff);
            $notes = $stockDiff > 0
                ? "Edit manual: stok ditambah {$qty} (dari {$oldStock} → {$newStock})"
                : "Edit manual: stok dikurangi {$qty} (dari {$oldStock} → {$newStock})";

            StockHistory::log($product->id, $type, $qty, $notes, 'manual_edit');
        }

        return redirect()->route('products.list')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.list')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
