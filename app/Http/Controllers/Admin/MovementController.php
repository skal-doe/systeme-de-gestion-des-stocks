<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Movement;
use App\Models\Supplier;
use App\Enums\MovementTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\MovementRequest;

class MovementController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Movement::class);

        $movements = Movement::with(['product', 'user', 'supplier'])->latest()->paginate(10);
        return Inertia::render('admin/movements/Index', ['movements' => $movements]);
    }

    public function create()
    {
        Gate::authorize('create', Movement::class);

        $products = Product::all();
        $users = User::all();
        $suppliers = Supplier::all();
        $types = MovementTypeEnum::cases();

        return Inertia::render('admin/movements/Form', [
            'products' => $products,
            'users' => $users,
            'suppliers' => $suppliers,
            'types' => $types,
        ]);
    }

    public function store(MovementRequest $request)
    {
        Gate::authorize('create', Movement::class);

        $validated = $request->validated();

        $movement = Movement::create($validated);

        $product = Product::find($validated['product_id']);
        if ($validated['type'] === MovementTypeEnum::IN->value) {
            $product->increaseStock($validated['quantity']);
        } else {
            $product->decreaseStock($validated['quantity']);
        }

        return redirect()->route('admin.movements.index')->with('message', 'Mouvement créé avec succès.');
    }

    public function show(Movement $movement)
    {
        Gate::authorize('view', $movement);

        $movement->load(['product', 'user', 'supplier']);
        return Inertia::render('admin/movements/Show', ['movement' => $movement]);
    }

    public function edit(Movement $movement)
    {
        Gate::authorize('update', $movement);

        $products = Product::all();
        $users = User::all();
        $suppliers = Supplier::all();
        $types = MovementTypeEnum::cases();

        return Inertia::render('admin/movements/Form', [
            'movement' => $movement,
            'products' => $products,
            'users' => $users,
            'suppliers' => $suppliers,
            'types' => $types,
        ]);
    }

    public function update(MovementRequest $request, Movement $movement)
    {
        Gate::authorize('update', $movement);

        $validated = $request->validated();

        // Annuler l'effet du mouvement précédent sur le stock
        $previousProduct = $movement->product;
        if ($movement->type === MovementTypeEnum::IN->value) {
            $previousProduct->decreaseStock($movement->quantity);
        } else {
            $previousProduct->increaseStock($movement->quantity);
        }

        $movement->update($validated);

        // Appliquer l'effet du nouveau mouvement sur le stock
        $newProduct = Product::find($validated['product_id']);
        if ($validated['type'] === MovementTypeEnum::IN->value) {
            $newProduct->increaseStock($validated['quantity']);
        } else {
            $newProduct->decreaseStock($validated['quantity']);
        }

        return redirect()->route('admin.movements.index')->with('message', 'Mouvement mis à jour avec succès.');
    }

    public function destroy(Movement $movement)
    {
        Gate::authorize('delete', $movement);

        // Annuler l'effet du mouvement sur le stock
        $product = $movement->product;
        if ($movement->type === MovementTypeEnum::IN->value) {
            $product->decreaseStock($movement->quantity);
        } else {
            $product->increaseStock($movement->quantity);
        }

        $movement->delete();

        return redirect()->route('admin.movements.index')->with('message', 'Mouvement supprimé avec succès.');
    }
}
