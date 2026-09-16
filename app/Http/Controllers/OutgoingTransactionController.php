<?php

namespace App\Http\Controllers;

use App\Models\OutgoingTransaction;
use App\Models\Item;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutgoingTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingTransaction::with([
            'department',
            'details.item'
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('transaction_number', 'like', "%{$search}%");
        }

        $transactions = $query
            ->latest('date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'outgoing_transactions.index',
            compact('transactions')
        );
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        $items = Item::orderBy('name')->get();

        return view(
            'outgoing_transactions.create',
            compact('departments', 'items')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'required|string|max:255|unique:outgoing_transactions,transaction_number',
            'date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            // Cek stok terlebih dahulu
            foreach ($validated['items'] as $detail) {

                $item = Item::lockForUpdate()
                    ->findOrFail($detail['item_id']);

                if ($item->stock < $detail['quantity']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => "Stok barang {$item->name} tidak mencukupi. Stok tersedia: {$item->stock}.",
                    ]);
                }
            }

            // Simpan transaksi utama
            $transaction = OutgoingTransaction::create([
                'transaction_number' => $validated['transaction_number'],
                'date' => $validated['date'],
                'department_id' => $validated['department_id'],
                'description' => $validated['description'] ?? null,
            ]);

            // Simpan detail dan kurangi stok
            foreach ($validated['items'] as $detail) {

                $transaction->details()->create([
                    'item_id' => $detail['item_id'],
                    'quantity' => $detail['quantity'],
                    'description' => $detail['description'] ?? null,
                ]);

                Item::where('id', $detail['item_id'])
                    ->decrement('stock', $detail['quantity']);
            }
        });

        return redirect()
            ->route('outgoing-transactions.index')
            ->with(
                'success',
                'Transaksi barang keluar berhasil disimpan dan stok telah diperbarui.'
            );
    }

    public function show(OutgoingTransaction $outgoingTransaction)
    {
        $outgoingTransaction->load([
            'department',
            'details.item'
        ]);

        return view(
            'outgoing_transactions.show',
            compact('outgoingTransaction')
        );
    }

    public function edit(OutgoingTransaction $outgoingTransaction)
    {
        //
    }

    public function update(
        Request $request,
        OutgoingTransaction $outgoingTransaction
    ) {
        //
    }

    public function destroy(OutgoingTransaction $outgoingTransaction)
    {
        //
    }
}