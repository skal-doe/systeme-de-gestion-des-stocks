<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Activity;
use App\Http\Requests\ProductRequest;
use Inertia\Inertia;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('name')->paginate(10);

        return Inertia::render('admin/products/Index', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return Inertia::render('admin/products/Form', [
            'categories' => $categories
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Admin/Products/Show', ['product' => $product]);
    }

    public function store(ProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return Inertia::render('admin/products/Form', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit modifié avec succès.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('message', 'Produit supprimé avec succès.');
    }

    public function trash()
    {
        $products = Product::with('category')->onlyTrashed()->orderBy('name')->paginate(10);

        return Inertia::render('admin/products/Trash', [
            'products' => $products
        ]);
    }


    public function restore(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')->with('message', 'Produit restauré avec succès.');
    }

    public function forceDelete(string $id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('admin.products.trash')->with('message', 'Produit supprimé définitivement.');
    }
}
