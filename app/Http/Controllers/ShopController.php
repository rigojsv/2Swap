<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        // Obtiene solo los productos que están disponibles
        $products = Product::where('status', 'available')->with('comments')->get();
    
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

    // Obtener productos relacionados basados en la misma categoría
    $relatedProducts = Product::where('category_id', $product->category_id)
                              ->where('id', '!=', $product->id) // Excluir el producto actual
                              ->where('status', 'available') // Solo productos disponibles
                              ->take(5) // Limitar la cantidad de productos relacionados
                              ->get();

    return view('shop-single', compact('product', 'images', 'averageRating', 'commentCount', 'relatedProducts'));
}
}