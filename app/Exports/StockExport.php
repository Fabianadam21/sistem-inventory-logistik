<?php

namespace App\Exports;

use App\Models\Item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromCollection, WithColumnWidths, WithCustomStartCell, WithEvents
{
    private const HEADER_ROW = 4;

    private const FIRST_DATA_ROW = 5;

    public function __construct(
        private readonly Collection $items,
        private readonly int $year,
        private readonly int $semester,
        private readonly array $months
    ) {
    }

    public function collection(): Collection
    {
        return $this->items->values()->map(function (Item $item, int $index): array {
            $row = [
                $index + 1,
                $item->code,
                $item->name,
                $item->category->name ?? '-',
                $item->unit->name ?? '-',
                $item->supplier->name ?? '-',
                $item->opening_stock,
            ];

            foreach ($this->months as $month) {
                $movement = $item->monthly_movements[$month['number']];
                $row[] = $movement['incoming'];
                $row[] = $movement['outgoing'];
            }

            $row[] = $item->total_incoming;
            $row[] = $item->total_outgoing;
            $row[] = $item->buffer_stock;
            $row[] = $item->price;
            $row[] = $item->total_value;
            $row[] = $item->minimum_stock;
            $row[] = $item->buffer_stock <= $item->minimum_stock ? 'Menipis' : 'Aman';

            return $row;
        });
    }

    public function startCell(): string
    {
        return 'A'.self::FIRST_DATA_ROW;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6, 'B' => 17, 'C' => 30, 'D' => 20, 'E' => 14, 'F' => 18, 'G' => 15,
            'H' => 12, 'I' => 12, 'J' => 12, 'K' => 12, 'L' => 12, 'M' => 12, 'N' => 12,
            'O' => 12, 'P' => 12, 'Q' => 12, 'R' => 12, 'S' => 12, 'T' => 14, 'U' => 14,
            'V' => 14, 'W' => 17, 'X' => 18, 'Y' => 12, 'Z' => 12,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = Coordinate::stringFromColumnIndex(26);
                $lastRow = max(self::FIRST_DATA_ROW, $sheet->getHighestRow());

                $sheet->setTitle("Stok S{$this->semester} {$this->year}");
                $sheet->mergeCells("A1:{$lastColumn}1");
                $sheet->mergeCells("A2:{$lastColumn}2");
                $sheet->setCellValue('A1', 'LAPORAN PERSEDIAAN BARANG');
                $sheet->setCellValue(
                    'A2',
                    sprintf(
                        'Semester %s · %d · %s',
                        $this->semester === 1 ? 'I' : 'II',
                        $this->year,
                        $this->semester === 1 ? 'Januari–Juni' : 'Juli–Desember'
                    )
                );

                $this->writeHeaders($sheet);
                $this->styleSheet($sheet, $lastColumn, $lastRow);
                foreach ($this->columnWidths() as $column => $width) {
                    $sheet->getColumnDimension($column)->setWidth($width);
                }
            },
        ];
    }

    private function writeHeaders(Worksheet $sheet): void
    {
        $fixedHeaders = [
            'No',
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Satuan',
            'Sumber Dana',
            $this->semester === 1
                ? 'Stok Awal'
                : 'Buffer Awal',
        ];

        foreach ($fixedHeaders as $index => $header) {
            $column = Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue("{$column}".self::HEADER_ROW, $header);
        }

        $monthStartColumn = count($fixedHeaders) + 1;
        foreach ($this->months as $index => $month) {
            $shortMonth = mb_substr($month['name'], 0, 3);
            $incomingColumn = Coordinate::stringFromColumnIndex($monthStartColumn + ($index * 2));
            $outgoingColumn = Coordinate::stringFromColumnIndex($monthStartColumn + ($index * 2) + 1);
            $sheet->setCellValue("{$incomingColumn}".self::HEADER_ROW, "{$shortMonth} Masuk");
            $sheet->setCellValue("{$outgoingColumn}".self::HEADER_ROW, "{$shortMonth} Keluar");
        }

        $totalStartColumn = $monthStartColumn + (count($this->months) * 2);
        $totalHeaders = [
            'Total Masuk',
            'Total Keluar',
            'Buffer Stock',
            'Harga Satuan',
            'Nilai Buffer',
            'Min. Stok',
            'Status',
        ];

        foreach ($totalHeaders as $index => $header) {
            $column = Coordinate::stringFromColumnIndex($totalStartColumn + $index);
            $sheet->setCellValue("{$column}".self::HEADER_ROW, $header);
        }
    }

    private function styleSheet(Worksheet $sheet, string $lastColumn, int $lastRow): void
    {
        $sheet->getRowDimension(1)->setRowHeight(28);
        $sheet->getRowDimension(2)->setRowHeight(21);
        $sheet->getRowDimension(3)->setRowHeight(8);
        $sheet->getRowDimension(self::HEADER_ROW)->setRowHeight(24);

        $sheet->getStyle("A1:{$lastColumn}1")->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '333333']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '666666']],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);

        $sheet->getStyle("A".self::HEADER_ROW.":{$lastColumn}".self::HEADER_ROW)->applyFromArray([
            'font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => '333333']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E9ECEF'],
            ],
        ]);

        if ($lastRow >= self::FIRST_DATA_ROW) {
            $sheet->getStyle('A'.self::FIRST_DATA_ROW.":{$lastColumn}{$lastRow}")->applyFromArray([
                'font' => ['size' => 10, 'color' => ['rgb' => '252525']],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getStyle('A'.self::FIRST_DATA_ROW.":A{$lastRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'.self::FIRST_DATA_ROW.":Y{$lastRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('Z'.self::FIRST_DATA_ROW.":Z{$lastRow}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->getStyle('G'.self::FIRST_DATA_ROW.":Y{$lastRow}")
                ->getNumberFormat()
                ->setFormatCode('#,##0;[Red]-#,##0;–');
            $sheet->getStyle('W'.self::FIRST_DATA_ROW.":X{$lastRow}")
                ->getNumberFormat()->setFormatCode('"Rp" #,##0;[Red]"Rp" -#,##0;–');
        }

        $sheet->setAutoFilter("A".self::HEADER_ROW.":{$lastColumn}{$lastRow}");
    }
}
