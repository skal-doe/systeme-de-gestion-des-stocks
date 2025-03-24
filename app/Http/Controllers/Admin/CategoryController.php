<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Category::class);

        $categories = Category::orderBy('name')->paginate();
        return Inertia::render('admin/categories/Index', ['categories' => $categories]);
    }

    public function create()
    {
        Gate::authorize('create', Category::class);

        return Inertia::render('admin/categories/Form');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        Gate::authorize('update', $category);

        return Inertia::render('admin/categories/Form', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        Gate::authorize('update', $category);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->delete();
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie supprimée avec succès.');
    }

    public function trash()
    {
        Gate::authorize('viewAny', Category::class);

        $categories = Category::onlyTrashed()->orderBy('name')->paginate(10);

        return Inertia::render('admin/categories/Trash', [
            'categories' => $categories
        ]);
    }

    public function restore($id)
    {
        Gate::authorize('restore', Category::class);

        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trash')->with('message', 'Catégorie restaurée avec succès.');
    }

    public function forceDelete($id)
    {
        Gate::authorize('forceDelete', Category::class);

        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.categories.trash')->with('message', 'Catégorie supprimée définitivement.');
    }
}
