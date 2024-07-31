<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        // Obtiene todos los productos, puedes ajustar esto según tus necesidades (paginación, filtros, etc.)
        $products = Product::with('comments')->get();

        // Agregar el promedio de calificaciones a cada producto
        $products->each(function ($product) {
            $product->averageRating = $product->comments->avg('rating') ?? 0;
        });
    
        // Muestra la vista 'shop' y pasa los productos
        return view('shop', compact('products'));
    }

    public function show($id)
    {
        // Encuentra el producto por ID
        $product = Product::findOrFail($id);

        $images = json_decode($product->images, true);

        // Calcular el promedio de calificaciones y el conteo de comentarios
        $averageRating = $product->comments->avg('rating') ?? 0;
        $commentCount = $product->comments->count();
    
        return view('shop-single', compact('product', 'images', 'averageRating', 'commentCount'));
    }
}