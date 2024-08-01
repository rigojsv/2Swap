<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Product $product)
    {
        // Validar los datos del comentario
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Crear y guardar el comentario
        Comment::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'date' => now(),
        ]);

        // Redirigir de vuelta a la página del producto con un mensaje de éxito
        return redirect()->route('shop.show', $product->id)->with('success', 'Comentario agregado con éxito.');
    }
}
