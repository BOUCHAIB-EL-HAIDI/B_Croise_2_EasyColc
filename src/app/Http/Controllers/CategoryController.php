<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $colocation = $user->activeMembership->colocation;
        $categories = $colocation->categories()->orderBy('name')->get();

        return view('categories.index', compact('categories', 'colocation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $colocationId = $user->activeMembership->colocation_id;

        Category::create([
            'colocation_id' => $colocationId,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Catégorie ajoutée avec succès !');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Authorization is handled by middleware and route binding, 
        // but we ensure the category belongs to the user's colocation.
        $user = Auth::user();
        if ($category->colocation_id !== $user->activeMembership->colocation_id) {
            abort(403);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(Category $category)
    {
        $user = Auth::user();
        if ($category->colocation_id !== $user->activeMembership->colocation_id) {
            abort(403);
        }

        // Check if there are expenses associated with this category
        if ($category->expenses()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette catégorie car elle contient des dépenses.');
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée avec succès !');
    }
}
