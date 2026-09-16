<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Item::with([
            'category',
            'unit',
            'warehouse'
        ])
        ->orderBy('name')
        ->get()
        ->map(function ($item) {

            return [
                $item->code,
                $item->name,
                $item->category->name ?? '-',
                $item->unit->name ?? '-',
                $item->warehouse->name ?? '-',
                $item->stock,
                $item->minimum_stock,
                $item->stock <= $item->minimum_stock
                    ? 'Menipis'
                    : 'Aman',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Gudang',
            'Stok',
            'Minimum Stok',
            'Status',
        ];
    }
}