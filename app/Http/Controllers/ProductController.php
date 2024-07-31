<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('newproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validaciones para imágenes
        ]);

        // Maneja la carga de archivos de imágenes
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('public/images'); // Guarda la imagen en el directorio public/images
                $imagePaths[] = Storage::url($imagePath); // Obtén la URL pública de la imagen
            }
        }

        // Crea un nuevo producto en la base de datos con el user_id autenticado
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(), // Obtén el ID del usuario autenticado
            'images' => json_encode($imagePaths), // Guarda las URLs de las imágenes en formato JSON
        ]);

        // Redirige al formulario con un mensaje de éxito
        return Redirect::route('product.create')->with('success', 'Producto agregado correctamente.');
    }
}
