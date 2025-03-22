<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovementRequest;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use App\Enums\MovementTypeEnum;
use Inertia\Inertia;

class MovementController extends Controller
{
    // Afficher la liste des mouvements
    public function index()
    {
        $movements = Movement::with(['product', 'user', 'supplier'])->latest()->paginate(10);
        return Inertia::render('admin/movements/Index', ['movements' => $movements]);
    }

    // Afficher le formulaire de création
    public function create()
    {
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

    // Enregistrer un nouveau mouvement
    public function store(MovementRequest $request)
    {
        $validated = $request->validated();

        // Créer le mouvement
        $movement = Movement::create($validated);

        // Mettre à jour le stock du produit
        $product = Product::find($validated['product_id']);
        if ($validated['type'] === MovementTypeEnum::IN->value) {
            $product->increaseStock($validated['quantity']);
        } else {
            $product->decreaseStock($validated['quantity']);
        }

        return redirect()->route('admin.movements.index')->with('message', 'Mouvement créé avec succès.');
    }

    // Afficher les détails d'un mouvement
    public function show(Movement $movement)
    {
        $movement->load(['product', 'user', 'supplier']);
        return Inertia::render('admin/movements/Show', ['movement' => $movement]);
    }

    // Afficher le formulaire de modification
    public function edit(Movement $movement)
    {
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

    // Mettre à jour un mouvement
    public function update(MovementRequest $request, Movement $movement)
    {
        $validated = $request->validated();

        // Annuler l'effet du mouvement précédent sur le stock
        $previousProduct = $movement->product;
        if ($movement->type === MovementTypeEnum::IN->value) {
            $previousProduct->decreaseStock($movement->quantity);
        } else {
            $previousProduct->increaseStock($movement->quantity);
        }

        // Mettre à jour le mouvement
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

    // Supprimer un mouvement
    public function destroy(Movement $movement)
    {
        // Annuler l'effet du mouvement sur le stock
        $product = $movement->product;
        if ($movement->type === MovementTypeEnum::IN->value) {
            $product->decreaseStock($movement->quantity);
        } else {
            $product->increaseStock($movement->quantity);
        }

        // Supprimer le mouvement
        $movement->delete();

        return redirect()->route('admin.movements.index')->with('message', 'Mouvement supprimé avec succès.');
    }
}
