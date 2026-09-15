<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\IncomingTransaction;
use App\Models\OutgoingTransaction;

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

        return view('dashboard', compact(
            'totalItems',
            'totalStock',
            'totalIncoming',
            'totalOutgoing',
            'lowStockItems',
            'recentIncoming',
            'recentOutgoing'
        ));
    }
}