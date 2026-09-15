<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $query = Item::with([
            'category',
            'unit',
            'warehouse'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('stock_status')) {

            if ($request->stock_status === 'low') {
                $query->whereColumn(
                    'stock',
                    '<=',
                    'minimum_stock'
                );
            }

            if ($request->stock_status === 'safe') {
                $query->whereColumn(
                    'stock',
                    '>',
                    'minimum_stock'
                );
            }
        }

        $items = $query
            ->orderBy('name')
            ->get();

        return view(
            'reports.stock',
            compact('items')
        );
    }
}