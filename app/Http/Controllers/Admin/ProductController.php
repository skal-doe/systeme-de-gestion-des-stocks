<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\ProductRequest;


class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);

        $products = Product::with('category')->orderBy('name')->paginate(10);

        return Inertia::render('admin/products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Product::class);

        $categories = Category::orderBy('name')->get();

        return Inertia::render('admin/products/Form', [
            'categories' => $categories
        ]);
    }

    public function show(Product $product)
    {
        Gate::authorize('view', $product);

        return Inertia::render('admin/products/Show', ['product' => $product->load('category')]);
    }

    public function store(ProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        Product::create($request->validated());

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        $categories = Category::orderBy('name')->get();

        return Inertia::render('admin/products/Form', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);

        $product->update($request->validated());

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit modifié avec succès.');
    }

    public function destroy(Product $product)
    {
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit supprimé avec succès.');
    }

    public function trash()
    {
        Gate::authorize('viewAny', Product::class);

        $products = Product::with('category')->onlyTrashed()->orderBy('name')->paginate(10);

        return Inertia::render('admin/products/Trash', [
            'products' => $products
        ]);
    }


    public function restore(string $id)
    {
        Gate::authorize('restore', Product::class);

        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')->with('message', 'Produit restauré avec succès.');
    }

    public function forceDelete(string $id)
    {
        Gate::authorize('forceDelete', Product::class);

        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('admin.products.trash')->with('message', 'Produit supprimé définitivement.');
    }
}
