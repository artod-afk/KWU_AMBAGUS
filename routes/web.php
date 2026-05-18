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
Route::get('/stock-history', function () {
    $histories = \App\Models\StockHistory::with('product')->latest()->get();
    return view('products.history', compact('histories'));
})->middleware(['auth'])->name('stock.history');

// Stok Barang
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
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
