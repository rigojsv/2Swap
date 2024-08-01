<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentPage()
    {
        $user = auth()->user();
        $cart = $user->cart;

        // Pasar el carrito a la vista de pago
        return view('paymentcart', compact('cart'));
    }
}
