<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate();
        return Inertia::render('admin/categories/Index', ['categories' => $categories]);
    }

    public function create()
    {
        return Inertia::render('admin/categories/Form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie créée avec succès.');
    }

    public function edit(Category $category)
    {
        return Inertia::render('admin/categories/Form', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('message', 'Catégorie supprimée avec succès.');
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->orderBy('name')->paginate(10);

        return Inertia::render('admin/categories/Trash', [
            'categories' => $categories
        ]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trash')->with('message', 'Catégorie restaurée avec succès.');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->forceDelete();
        return redirect()->route('admin.categories.trash')->with('message', 'Catégorie supprimée définitivement.');
    }
}
