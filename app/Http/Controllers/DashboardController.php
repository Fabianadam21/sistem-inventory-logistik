<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();

        $totalStock = Item::sum('stock');

        $totalIncoming = IncomingTransaction::count();

        $totalOutgoing = OutgoingTransaction::count();

        $lowStockItems = Item::whereColumn(
            'stock',
            '<=',
            'minimum_stock'
        )
        ->orderBy('stock')
        ->get();

        $recentIncoming = IncomingTransaction::with('supplier')
            ->latest('date')
            ->take(5)
            ->get();

        $recentOutgoing = OutgoingTransaction::with('department')
            ->latest('date')
            ->take(5)
            ->get();

        /*
         * Data grafik 6 bulan terakhir
         */

        $startDate = Carbon::now()
            ->startOfMonth()
            ->subMonths(5);

        $endDate = Carbon::now()
            ->endOfMonth();

        $incomingTransactions = IncomingTransaction::whereBetween(
            'date',
            [$startDate, $endDate]
        )->get();

        $outgoingTransactions = OutgoingTransaction::whereBetween(
            'date',
            [$startDate, $endDate]
        )->get();

        $chartLabels = [];
        $incomingChartData = [];
        $outgoingChartData = [];

        for ($i = 0; $i < 6; $i++) {

            $month = $startDate->copy()->addMonths($i);

            $key = $month->format('Y-m');

            $chartLabels[] = $month->translatedFormat('M Y');

            $incomingChartData[] = $incomingTransactions
                ->filter(function ($transaction) use ($key) {
                    return $transaction->date->format('Y-m') === $key;
                })
                ->count();

            $outgoingChartData[] = $outgoingTransactions
                ->filter(function ($transaction) use ($key) {
                    return $transaction->date->format('Y-m') === $key;
                })
                ->count();
        }

        return view('dashboard', compact(
            'totalItems',
            'totalStock',
            'totalIncoming',
            'totalOutgoing',
            'lowStockItems',
            'recentIncoming',
            'recentOutgoing',
            'chartLabels',
            'incomingChartData',
            'outgoingChartData'
        ));
    }
}