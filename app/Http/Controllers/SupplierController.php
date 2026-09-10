<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->get();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
        ]);

        Supplier::create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        //
    }

    public function edit(Supplier $supplier)
    {
        //
    }

    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    public function destroy(Supplier $supplier)
    {
        //
    }
}