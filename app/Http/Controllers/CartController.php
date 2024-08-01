<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProduct(Request $request, $productId)
    {
        $user = auth()->user();
        $product = Product::findOrFail($productId);

        // Obtener o crear el carrito del usuario
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        // Verificar si el producto ya está en el carrito
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Si el producto ya está en el carrito, aumentar la cantidad
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Agregar el producto al carrito
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    public function viewCart()
    {
        $user = auth()->user();
        $cart = $user->cart;

        return view('cart', compact('cart'));
    }

public function removeCartItem($itemId)
{
    $user = auth()->user();
    $cart = $user->cart;

    // Encuentra el ítem del carrito
    $cartItem = $cart->items()->findOrFail($itemId);

    // Elimina el ítem del carrito
    $cartItem->delete();

    return redirect()->back()->with('success', 'Ítem eliminado del carrito');
}

}
