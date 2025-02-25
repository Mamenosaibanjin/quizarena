<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Gibt alle Kategorien zurück
    public function index()
    {
        return response()->json(Category::all());
    }

    // Erstellt eine neue Kategorie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500', // Beschreibung optional
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }
}
