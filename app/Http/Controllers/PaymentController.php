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
        // Validar los datos del formulario de pago
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|size:10',
            'zip' => 'required|string|size:5',
            'instructions' => 'nullable|string',
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string|size:5',
            'cvc' => 'required|string|size:3',
        ]);

        // Obtener el carrito del usuario
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'No hay artículos en el carrito.');
        }

        // Guardar la transacción para cada ítem del carrito
        foreach ($cart->items as $item) {
            Transaction::create([
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total' => $item->product->price * $item->quantity,
                'status' => 'completed',
            ]);
        }

        // Vaciar el carrito después del pago
        $cart->items()->delete();
        
        // Mostrar mensaje de éxito
        return redirect()->route('orders.index')->with('success', 'Pago realizado con éxito. ¡Gracias por su compra!');
    }
}
