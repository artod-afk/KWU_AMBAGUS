<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\CashierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Stock History
Route::get('/stock-history', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\StockHistory::with('product')->latest();

    if ($request->search) {
        $query->whereHas('product', fn($q) => $q->where('name', 'like', '%'.$request->search.'%'));
    }
    if ($request->type) {
        $query->where('type', $request->type);
    }
    if ($request->source) {
        $query->where('source', $request->source);
    }
    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $histories = $query->paginate(20);
    return view('products.history', compact('histories'));
})->middleware(['auth'])->name('stock.history');

// Stok Barang
Route::middleware(['auth'])->group(function () {
    // Landing page stok (dashboard stok)
    Route::get('/products', [ProductController::class, 'landing'])->name('products.index');
    // Tabel stok barang (halaman lama)
    Route::get('/products/list', [ProductController::class, 'index'])->name('products.list');
    // CRUD routes manual (hindari konflik dengan 'list')
    Route::get('/products/create',        [ProductController::class, 'create'])->name('products.create');
    Route::post('/products',              [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit',[ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',     [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',  [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/{product}',     [ProductController::class, 'show'])->name('products.show');

    Route::resource('categories', CategoryController::class);
});

// Kasir POS
Route::middleware(['auth'])->prefix('cashier')->group(function () {
    Route::get('/',              [CashierController::class, 'index'])->name('cashier.index');
    Route::get('/pos',           [CashierController::class, 'pos'])->name('cashier.pos');
    Route::get('/search',        [CashierController::class, 'searchProduct'])->name('cashier.search');
    Route::post('/checkout',     [CashierController::class, 'checkout'])->name('cashier.checkout');
    Route::get('/log',           [CashierController::class, 'log'])->name('cashier.log');
    Route::get('/detail/{transaction}', [CashierController::class, 'detail'])->name('cashier.detail');
    Route::get('/income-history', [CashierController::class, 'incomeHistory'])->name('cashier.income.history');
});

// Keuangan
Route::middleware(['auth'])->prefix('finance')->group(function () {
    Route::resource('incomes', IncomeController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::get('/report', [FinanceReportController::class, 'index'])->name('finance.report');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
