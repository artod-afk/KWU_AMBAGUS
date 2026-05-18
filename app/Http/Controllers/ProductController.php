<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\StockHistory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

        StockHistory::create([
            'product_id' => $product->id,
            'type'       => 'masuk',
            'quantity'   => $request->stock,
        ]);

        return redirect()->route('products.index')
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

        $product->update([
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'stock'          => $request->stock,
            'minimum_stock'  => $request->minimum_stock,
            'price'          => $request->selling_price,
            'purchase_price' => $request->purchase_price,
            'selling_price'  => $request->selling_price,
            'profit'         => $profit,
            'unit'           => $request->unit,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
