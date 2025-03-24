<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\SupplierRequest;

class SupplierController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Supplier::class);

        $suppliers = Supplier::latest()->paginate(10);

        return Inertia::render('admin/suppliers/Index', ['suppliers' => $suppliers]);
    }

    public function create()
    {
        Gate::authorize('create', Supplier::class);

        return Inertia::render('admin/suppliers/Form');
    }

    public function store(SupplierRequest $request)
    {
        Gate::authorize('create', Supplier::class);

        $validated = $request->validated();

        Supplier::create($validated);
        return redirect()->route('admin.suppliers.index')->with('message', 'Fournisseur créé avec succès.');
    }

    public function show(Supplier $supplier)
    {
        Gate::authorize('view', $supplier);

        return Inertia::render('admin/suppliers/Show', ['supplier' => $supplier]);
    }

    public function edit(Supplier $supplier)
    {
        Gate::authorize('update', $supplier);

        return Inertia::render('admin/suppliers/Form', ['supplier' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        Gate::authorize('update', $supplier);

        $validated = $request->validated();

        $supplier->update($validated);
        return redirect()->route('admin.suppliers.index')->with('message', 'Fournisseur mis à jour avec succès.');
    }

    public function destroy(Supplier $supplier)
    {
        Gate::authorize('delete', $supplier);

        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('message', 'Fournisseur supprimé avec succès.');
    }

    public function trash()
    {
        Gate::authorize('viewAny', Supplier::class);

        $suppliers = Supplier::onlyTrashed()->orderBy('name')->paginate(10);

        return Inertia::render('admin/suppliers/Trash', [
            'suppliers' => $suppliers
        ]);
    }

    public function restore(string $id)
    {
        Gate::authorize('restore', Supplier::class);

        $supplier = Supplier::withTrashed()->findOrFail($id);
        $supplier->restore();
        return redirect()->route('admin.suppliers.trash')->with('message', 'Fournisseur restauré avec succès.');
    }

    public function forceDelete(string $id)
    {
        Gate::authorize('forceDelete', Supplier::class);

        $supplier = Supplier::withTrashed()->findOrFail($id);
        $supplier->forceDelete();
        return redirect()->route('admin.suppliers.trash')->with('message', 'Fournisseur supprimé définitivement.');
    }
}
