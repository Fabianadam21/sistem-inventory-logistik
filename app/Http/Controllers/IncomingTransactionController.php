<?php

namespace App\Http\Controllers;

use App\Models\IncomingTransaction;
use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomingTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingTransaction::with([
            'supplier',
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
            'incoming_transactions.index',
            compact('transactions')
        );
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();

        $items = Item::orderBy('name')->get();

        return view(
            'incoming_transactions.create',
            compact('suppliers', 'items')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_number' => 'required|string|max:255|unique:incoming_transactions,transaction_number',
            'date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'nullable|string',

            'items' => 'required|array|min:1',

            'items.*.item_id' => 'required|exists:items,id',

            'items.*.quantity' => 'required|integer|min:1',

            'items.*.price' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {

            $transaction = \App\Models\IncomingTransaction::create([
                'transaction_number' => $validated['transaction_number'],
                'date' => $validated['date'],
                'supplier_id' => $validated['supplier_id'],
                'description' => $validated['description'] ?? null,
            ]);

            foreach ($validated['items'] as $detail) {

                $transaction->details()->create([
                    'item_id' => $detail['item_id'],
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'] ?? null,
                ]);

                $item = \App\Models\Item::findOrFail(
                    $detail['item_id']
                );

                $item->increment(
                    'stock',
                    $detail['quantity']
                );
            }
        });

        return redirect()
            ->route('incoming-transactions.index')
            ->with(
                'success',
                'Transaksi barang masuk berhasil disimpan dan stok telah diperbarui.'
            );
    }

    public function show(IncomingTransaction $incomingTransaction)
    {
        $incomingTransaction->load([
            'supplier',
            'details.item'
        ]);

        return view(
            'incoming_transactions.show',
            compact('incomingTransaction')
        );
    }

    public function edit(IncomingTransaction $incomingTransaction)
    {
        //
    }

    public function update(
        Request $request,
        IncomingTransaction $incomingTransaction
    ) {
        //
    }

    public function destroy(IncomingTransaction $incomingTransaction)
    {
        //
    }
}