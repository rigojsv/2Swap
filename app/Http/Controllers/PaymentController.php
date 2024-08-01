<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        $user = auth()->user();
        $cart = $user->cart;

        // Pasar el carrito a la vista de pago
        return view('paymentcart', compact('cart'));
    }

    public function processPayment(Request $request)
{
    // Validar los datos del formulario
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:10',
        'zip' => 'required|string|max:5',
        'instructions' => 'nullable|string',
        'card_number' => 'required|string|size:16',
        'expiry_date' => 'required|string|size:5',
        'cvc' => 'required|string|size:3',
    ]);

    // Obtener el carrito del usuario
    $cart = Cart::where('user_id', Auth::id())->first();

    if (!$cart) {
        return redirect()->route('paymentcart')->with('error', 'El carrito está vacío.');
    }

    // Procesar cada ítem del carrito
    foreach ($cart->items as $item) {
        // Crear una transacción
        Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $item->product_id,
            'total' => $item->product->price * $item->quantity,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'zip' => $request->input('zip'),
            'instructions' => $request->input('instructions'),
            'card_number' => $request->input('card_number'),
            'expiry_date' => $request->input('expiry_date'),
            'cvc' => $request->input('cvc'),
            'status' => 'completed', // Puedes cambiar el estado según tu lógica
        ]);

        // Actualizar el estado del producto a 'sold'
        $product = Product::find($item->product_id);
        if ($product) {
            $product->status = 'sold';
            $product->save();
        }
    }

    // Vaciar el carrito
    $cart->items()->delete();
    $cart->delete();

    // Redirigir con mensaje de éxito
    return redirect()->route('orders.index')->with('success', 'Pedido realizado con éxito.');
}
}
