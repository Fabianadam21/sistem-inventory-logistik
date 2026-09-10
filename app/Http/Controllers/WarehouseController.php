<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('name')->get();

        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:warehouses,name',
        ]);

        Warehouse::create($validated);

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function show(Warehouse $warehouse)
    {
        //
    }

    public function edit(Warehouse $warehouse)
    {
        //
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    public function destroy(Warehouse $warehouse)
    {
        //
    }
}