<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = \App\Models\Item::with([
            'category',
            'unit',
            'warehouse'
        ])->latest()->get();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        $units = \App\Models\Unit::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();

        return view('items.create', compact(
            'categories',
            'units',
            'warehouses'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:items,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Item::create($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Item $item)
    {
        $categories = \App\Models\Category::orderBy('name')->get();
        $units = \App\Models\Unit::orderBy('name')->get();
        $warehouses = \App\Models\Warehouse::orderBy('name')->get();

        return view('items.edit', compact(
            'item',
            'categories',
            'units',
            'warehouses'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:items,code,' . $item->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $item->update($validated);

        return redirect()
            ->route('items.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }

}
