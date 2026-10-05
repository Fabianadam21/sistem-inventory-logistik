<?php

namespace App\Services;

use App\Models\Item;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StockReportService
{
    private const MONTH_NAMES = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    public function months(int $year, int $semester): array
    {
        $firstMonth = $semester === 1 ? 1 : 7;

        return collect(range($firstMonth, $firstMonth + 5))
            ->map(fn (int $month): array => [
                'number' => $month,
                'name' => self::MONTH_NAMES[$month],
            ])
            ->all();
    }

    public function build(int $year, int $semester): Collection
    {
        $months = $this->months($year, $semester);
        $firstMonth = $months[0]['number'];
        $lastMonth = $months[5]['number'];
        $periodStart = CarbonImmutable::create($year, $firstMonth, 1)->startOfDay();
        $periodEnd = CarbonImmutable::create($year, $lastMonth, 1)->endOfMonth()->endOfDay();

        $items = Item::with(['category', 'unit', 'supplier'])
            ->orderBy('name')
            ->get();

        $incomingByItem = $this->movementsSince($periodStart, 'incoming_details', 'incoming_transactions');
        $outgoingByItem = $this->movementsSince($periodStart, 'outgoing_details', 'outgoing_transactions');

        return $items->map(function (Item $item) use (
            $months,
            $periodEnd,
            $incomingByItem,
            $outgoingByItem
        ): Item {
            $incoming = $incomingByItem->get($item->id, collect());
            $outgoing = $outgoingByItem->get($item->id, collect());
            $totalIncomingSinceStart = (int) $incoming->sum('quantity');
            $totalOutgoingSinceStart = (int) $outgoing->sum('quantity');
            // Reverse recorded movements from the current balance to reconstruct the period opening balance.
            $item->setAttribute(
                'opening_stock',
                (int) $item->stock - $totalIncomingSinceStart + $totalOutgoingSinceStart
            );

            $monthlyMovements = [];
            foreach ($months as $month) {
                $monthlyMovements[$month['number']] = ['incoming' => 0, 'outgoing' => 0];
            }

            foreach ($incoming as $movement) {
                $date = CarbonImmutable::parse($movement->date);
                if ($date->lessThanOrEqualTo($periodEnd)) {
                    $monthlyMovements[$date->month]['incoming'] += (int) $movement->quantity;
                }
            }

            foreach ($outgoing as $movement) {
                $date = CarbonImmutable::parse($movement->date);
                if ($date->lessThanOrEqualTo($periodEnd)) {
                    $monthlyMovements[$date->month]['outgoing'] += (int) $movement->quantity;
                }
            }

            $periodIncoming = array_sum(array_column($monthlyMovements, 'incoming'));
            $periodOutgoing = array_sum(array_column($monthlyMovements, 'outgoing'));
            $bufferStock = (int) $item->opening_stock + $periodIncoming - $periodOutgoing;

            $item->setAttribute('monthly_movements', $monthlyMovements);
            $item->setAttribute('total_incoming', $periodIncoming);
            $item->setAttribute('total_outgoing', $periodOutgoing);
            $item->setAttribute('buffer_stock', $bufferStock);
            $item->setAttribute(
                'total_value',
                $item->price === null ? null : $bufferStock * (float) $item->price
            );

            return $item;
        });
    }

    private function movementsSince(
        CarbonImmutable $periodStart,
        string $detailTable,
        string $transactionTable
    ): Collection {
        return DB::table($detailTable)
            ->join(
                $transactionTable,
                "{$transactionTable}.id",
                '=',
                "{$detailTable}.".($detailTable === 'incoming_details'
                    ? 'incoming_transaction_id'
                    : 'outgoing_transaction_id')
            )
            ->whereDate("{$transactionTable}.date", '>=', $periodStart->toDateString())
            ->select("{$detailTable}.item_id", "{$transactionTable}.date", "{$detailTable}.quantity")
            ->get()
            ->groupBy('item_id');
    }
}
