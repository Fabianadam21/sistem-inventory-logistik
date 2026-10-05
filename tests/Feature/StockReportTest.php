<?php

namespace Tests\Feature;

use App\Exports\StockExport;
use App\Models\Category;
use App\Models\Department;
use App\Models\IncomingDetail;
use App\Models\IncomingTransaction;
use App\Models\Item;
use App\Models\OutgoingDetail;
use App\Models\OutgoingTransaction;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use App\Services\StockReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Tests\TestCase;

class StockReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_report_carries_semester_one_buffer_into_semester_two(): void
    {
        $this->createAdmin();
        $item = $this->createItemWithSemesterMovements();
        $service = app(StockReportService::class);

        $semesterOne = $service->build(2026, 1)->first();
        $this->assertSame(15, (int) $semesterOne->opening_stock);
        $this->assertSame(10, (int) $semesterOne->monthly_movements[1]['incoming']);
        $this->assertSame(5, (int) $semesterOne->monthly_movements[2]['outgoing']);
        $this->assertSame(10, (int) $semesterOne->total_incoming);
        $this->assertSame(5, (int) $semesterOne->total_outgoing);
        $this->assertSame(20, (int) $semesterOne->buffer_stock);
        $this->assertSame(20000.0, (float) $semesterOne->total_value);

        $semesterTwo = $service->build(2026, 2)->first();
        $this->assertSame($item->id, $semesterTwo->id);
        $this->assertSame(20, (int) $semesterTwo->opening_stock);
        $this->assertSame(8, (int) $semesterTwo->monthly_movements[7]['incoming']);
        $this->assertSame(3, (int) $semesterTwo->monthly_movements[8]['outgoing']);
        $this->assertSame(25, (int) $semesterTwo->buffer_stock);
    }

    public function test_stock_report_page_shows_monthly_and_semester_totals(): void
    {
        $this->createAdmin();
        $this->createItemWithSemesterMovements();

        $this->get(route('reports.stock', ['year' => 2026, 'semester' => 2]))
            ->assertOk()
            ->assertSee('Laporan Persediaan Barang')
            ->assertSee('Semester II 2026')
            ->assertSee('Buffer Stock Awal')
            ->assertSee('Total Barang Masuk')
            ->assertSee('Total Barang Keluar')
            ->assertSee('Total Harga')
            ->assertSee('Buffer Stock')
            ->assertSee('25')
            ->assertSee('Rp 25.000');

        $excelResponse = $this->get(route('reports.stock.excel', [
            'year' => 2026,
            'semester' => 2,
        ]));
        $excelResponse->assertOk();
        $this->assertStringContainsString(
            'laporan-persediaan-semester-2-2026.xlsx',
            $excelResponse->headers->get('content-disposition')
        );

        $pdfResponse = $this->get(route('reports.stock.pdf', [
            'year' => 2026,
            'semester' => 2,
        ]));
        $pdfResponse->assertOk();
        $this->assertStringContainsString(
            'laporan-persediaan-semester-2-2026.pdf',
            $pdfResponse->headers->get('content-disposition')
        );
    }

    public function test_excel_export_has_simple_headers_and_readable_columns(): void
    {
        $this->createAdmin();
        $this->createItemWithSemesterMovements();
        $items = app(StockReportService::class)->build(2026, 2);
        $months = app(StockReportService::class)->months(2026, 2);
        $contents = Excel::raw(new StockExport($items, 2026, 2, $months), ExcelFormat::XLSX);
        $path = tempnam(sys_get_temp_dir(), 'simlog-stock-report-');

        try {
            file_put_contents($path, $contents);
            $sheet = IOFactory::load($path)->getActiveSheet();

            $this->assertSame('LAPORAN PERSEDIAAN BARANG', $sheet->getCell('A1')->getValue());
            $this->assertSame('Semester II · 2026 · Juli–Desember', $sheet->getCell('A2')->getValue());
            $this->assertSame('Buffer Stock', $sheet->getCell('V4')->getValue());
            $this->assertSame('Jul Masuk', $sheet->getCell('H4')->getValue());
            $this->assertSame('Jul Keluar', $sheet->getCell('I4')->getValue());
            $this->assertSame('Makanan Siap Saji', $sheet->getCell('C5')->getValue());
            $this->assertSame(20, $sheet->getCell('G5')->getValue());
            $this->assertSame(25, $sheet->getCell('V5')->getValue());
            $this->assertNull($sheet->getFreezePane());
            $this->assertSame(30.0, $sheet->getColumnDimension('C')->getWidth());
            $this->assertSame(
                'E9ECEF',
                $sheet->getStyle('V4')->getFill()->getStartColor()->getRGB()
            );
            $this->assertSame(
                'General',
                $sheet->getStyle('C5')->getNumberFormat()->getFormatCode()
            );
            $this->assertSame(
                '"Rp" #,##0;[Red]"Rp" -#,##0;–',
                $sheet->getStyle('W5')->getNumberFormat()->getFormatCode()
            );
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    private function createAdmin(): void
    {
        $this->actingAs(User::create([
            'name' => 'Administrator',
            'email' => 'admin-stock-report@example.test',
            'password' => 'password',
            'role' => 'admin',
        ]));
    }

    private function createItemWithSemesterMovements(): Item
    {
        $supplier = Supplier::create(['name' => 'APBD']);
        $department = Department::create(['name' => 'Bidang Uji']);
        $item = Item::create([
            'code' => 'STOCK-REPORT-001',
            'name' => 'Makanan Siap Saji',
            'category_id' => Category::create(['name' => 'Logistik'])->id,
            'unit_id' => Unit::create(['name' => 'Paket'])->id,
            'supplier_id' => $supplier->id,
            'stock' => 25,
            'minimum_stock' => 2,
            'price' => 1000,
        ]);

        $incomingOne = IncomingTransaction::create([
            'transaction_number' => 'IN-STOCK-REPORT-1',
            'date' => '2026-01-15',
            'supplier_id' => $supplier->id,
        ]);
        IncomingDetail::create([
            'incoming_transaction_id' => $incomingOne->id,
            'item_id' => $item->id,
            'quantity' => 10,
            'price' => 1000,
        ]);

        $outgoingOne = OutgoingTransaction::create([
            'transaction_number' => 'OUT-STOCK-REPORT-1',
            'date' => '2026-02-10',
            'department_id' => $department->id,
        ]);
        OutgoingDetail::create([
            'outgoing_transaction_id' => $outgoingOne->id,
            'item_id' => $item->id,
            'quantity' => 5,
        ]);

        $incomingTwo = IncomingTransaction::create([
            'transaction_number' => 'IN-STOCK-REPORT-2',
            'date' => '2026-07-12',
            'supplier_id' => $supplier->id,
        ]);
        IncomingDetail::create([
            'incoming_transaction_id' => $incomingTwo->id,
            'item_id' => $item->id,
            'quantity' => 8,
            'price' => 1000,
        ]);

        $outgoingTwo = OutgoingTransaction::create([
            'transaction_number' => 'OUT-STOCK-REPORT-2',
            'date' => '2026-08-20',
            'department_id' => $department->id,
        ]);
        OutgoingDetail::create([
            'outgoing_transaction_id' => $outgoingTwo->id,
            'item_id' => $item->id,
            'quantity' => 3,
        ]);

        return $item;
    }
}
