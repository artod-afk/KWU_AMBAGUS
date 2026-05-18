<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceReportController extends Controller
{
    /**
     * Display finance report
     */
    public function index(Request $request)
    {
        // Default date range: bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Total pemasukan
        $totalIncome = Income::whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('total');

        // Total pengeluaran
        $totalExpense = Expense::whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('total');

        // Keuntungan
        $profit = $totalIncome - $totalExpense;

        // Riwayat transaksi terbaru (gabungan income dan expense)
        $recentIncomes = Income::with('product')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->latest('transaction_date')
            ->take(5)
            ->get()
            ->map(function($income) {
                return [
                    'type' => 'income',
                    'product_name' => $income->product->name,
                    'quantity' => $income->quantity,
                    'price' => $income->selling_price,
                    'total' => $income->total,
                    'date' => $income->transaction_date,
                    'notes' => $income->notes
                ];
            });

        $recentExpenses = Expense::with('product')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->latest('transaction_date')
            ->take(5)
            ->get()
            ->map(function($expense) {
                return [
                    'type' => 'expense',
                    'product_name' => $expense->product->name,
                    'quantity' => $expense->quantity,
                    'price' => $expense->purchase_price,
                    'total' => $expense->total,
                    'date' => $expense->transaction_date,
                    'supplier' => $expense->supplier,
                    'notes' => $expense->notes
                ];
            });

        $recentTransactions = $recentIncomes->concat($recentExpenses)
            ->sortByDesc('date')
            ->take(10);

        // Data untuk grafik (per hari dalam range)
        $chartData = $this->getChartData($startDate, $endDate);

        return view('finance.report.index', compact(
            'totalIncome',
            'totalExpense',
            'profit',
            'recentTransactions',
            'chartData',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Get chart data for income and expense
     */
    private function getChartData($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $dates = [];
        $incomeData = [];
        $expenseData = [];

        // Generate dates
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $dates[] = $date->format('d M');

            // Get income for this date
            $incomeData[] = Income::whereDate('transaction_date', $dateStr)->sum('total');

            // Get expense for this date
            $expenseData[] = Expense::whereDate('transaction_date', $dateStr)->sum('total');
        }

        return [
            'labels' => $dates,
            'income' => $incomeData,
            'expense' => $expenseData
        ];
    }
}
