<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function incoming(Request $request)
    {
        $query = \App\Models\IncomingTransaction::with([
            'supplier',
            'details.item'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'transaction_number',
                'like',
                "%{$search}%"
            );
        }

        if ($request->filled('supplier_id')) {
            $query->where(
                'supplier_id',
                $request->supplier_id
            );
        }

        if ($request->filled('start_date')) {
            $query->whereDate(
                'date',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'date',
                '<=',
                $request->end_date
            );
        }

        $transactions = $query
            ->latest('date')
            ->get();

        $suppliers = \App\Models\Supplier::orderBy('name')->get();

        return view(
            'reports.incoming',
            compact(
                'transactions',
                'suppliers'
            )
        );
    }

    public function outgoing(Request $request)
    {
        $query = \App\Models\OutgoingTransaction::with([
            'department',
            'details.item'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'transaction_number',
                'like',
                "%{$search}%"
            );
        }

        if ($request->filled('department_id')) {
            $query->where(
                'department_id',
                $request->department_id
            );
        }

        if ($request->filled('start_date')) {
            $query->whereDate(
                'date',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'date',
                '<=',
                $request->end_date
            );
        }

        $transactions = $query
            ->latest('date')
            ->get();

        $departments = \App\Models\Department::orderBy('name')->get();

        return view(
            'reports.outgoing',
            compact(
                'transactions',
                'departments'
            )
        );
    }

    public function exportStockExcel()
    {
        return Excel::download(
            new StockExport,
            'laporan-stok.xlsx'
        );
    }

    public function exportStockPdf()
    {
        $items = \App\Models\Item::with([
            'category',
            'unit',
            'warehouse'
        ])
            ->orderBy('name')
            ->get();

        $pdf = Pdf::loadView(
            'reports.pdf.stock',
            compact('items')
        );

        return $pdf->download('laporan-stok.pdf');
    }
}