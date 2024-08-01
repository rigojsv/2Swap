<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

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
            'phone' => 'required|string|max:10',
            'zip' => 'required|string|max:5',
            'card_number' => 'required|string|size:16',
            'expiry_date' => 'required|string|size:5',
            'cvc' => 'required|string|size:3',
        ]);

        // Obtener el carrito del usuario
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->withErrors(['cart' => 'No hay artículos en el carrito.']);
        }

        // Procesar el pago (aquí iría la lógica del procesador de pagos)
        // ...

        // Crear la transacción en la base de datos
        foreach ($cart->items as $item) {
            Transaction::create([
                'user_id' => Auth::id(),
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total' => $item->product->price * $item->quantity,
                'status' => 'completed',
            ]);
        }

        // Vaciar el carrito
        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('dashboard')->with('success', 'Pago realizado exitosamente y transacción guardada.');
    }
}
