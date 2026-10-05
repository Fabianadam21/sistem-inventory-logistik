<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Exports\StockExport;
use App\Services\StockReportService;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function stock(Request $request)
    {
        $report = $this->stockReportData($request);
        $items = $report['items'];

        return view('reports.stock', [
            ...$report,
            'items' => $items,
            'summary' => [
                'items' => $items->count(),
                'opening_stock' => $items->sum('opening_stock'),
                'total_incoming' => $items->sum('total_incoming'),
                'total_outgoing' => $items->sum('total_outgoing'),
                'buffer_stock' => $items->sum('buffer_stock'),
                'total_value' => $items->contains(
                    fn (Item $item): bool => $item->price !== null
                ) ? $items->sum('total_value') : null,
            ],
        ]);
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

    public function exportStockExcel(Request $request)
    {
        $report = $this->stockReportData($request);

        return Excel::download(
            new StockExport(
                $report['items'],
                $report['year'],
                $report['semester'],
                $report['months']
            ),
            "laporan-persediaan-semester-{$report['semester']}-{$report['year']}.xlsx"
        );
    }

    public function exportStockPdf(Request $request)
    {
        $report = $this->stockReportData($request);

        $pdf = Pdf::loadView(
            'reports.pdf.stock',
            $report
        )->setPaper('a4', 'landscape');

        return $pdf->download(
            "laporan-persediaan-semester-{$report['semester']}-{$report['year']}.pdf"
        );
    }

    private function stockReportData(Request $request): array
    {
        $validated = $request->validate([
            'year' => 'sometimes|integer|min:2000|max:2100',
            'semester' => 'sometimes|in:1,2',
            'search' => 'nullable|string|max:255',
            'stock_status' => 'nullable|in:low,safe',
        ]);

        $year = (int) ($validated['year'] ?? now()->year);
        $semester = (int) ($validated['semester'] ?? (now()->month <= 6 ? 1 : 2));
        $stockReportService = app(StockReportService::class);
        $months = $stockReportService->months($year, $semester);
        $items = $stockReportService->build($year, $semester);

        if (! empty($validated['search'])) {
            $search = mb_strtolower($validated['search']);
            $items = $items->filter(fn (Item $item): bool =>
                str_contains(mb_strtolower($item->code), $search)
                || str_contains(mb_strtolower($item->name), $search)
            )->values();
        }

        if (($validated['stock_status'] ?? null) === 'low') {
            $items = $items->filter(
                fn (Item $item): bool => $item->buffer_stock <= $item->minimum_stock
            )->values();
        } elseif (($validated['stock_status'] ?? null) === 'safe') {
            $items = $items->filter(
                fn (Item $item): bool => $item->buffer_stock > $item->minimum_stock
            )->values();
        }

        $periodName = $semester === 1 ? 'Semester I' : 'Semester II';
        $periodRange = $semester === 1 ? 'Januari–Juni' : 'Juli–Desember';

        return [
            'items' => $items,
            'year' => $year,
            'semester' => $semester,
            'months' => $months,
            'period_title' => "{$periodName} {$year} ({$periodRange})",
            'opening_stock_label' => $semester === 1
                ? "Stok Awal (1 Januari {$year})"
                : "Buffer Stock Awal (1 Juli {$year})",
        ];
    }
}