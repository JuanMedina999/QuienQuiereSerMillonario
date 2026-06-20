<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   public function index()
{
    return response()->json(
        Category::with([
            'questions.answers'
        ])
        ->orderBy('name')
        ->get()
    );
}

    // Crear categoría
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $category
        ], 201);
    }

    // Mostrar una categoría
    public function show($id)
    {
        return response()->json(
            Category::findOrFail($id)
        );
    }

    // Actualizar categoría
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Categoría actualizada correctamente',
            'data' => $category
        ]);
    }

    // Eliminar categoría
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json([
            'message' => 'Categoría eliminada correctamente'
        ]);
    }
    public function adminData()
{
    return response()->json(
        Category::with([
            'questions.answers'
        ])
        ->orderBy('name')
        ->get()
    );
}
}