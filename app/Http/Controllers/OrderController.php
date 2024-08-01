<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function index()
    {
        // Obtener las transacciones del usuario autenticado
        $orders = Transaction::where('user_id', Auth::id())->get();
        
        // Pasar las transacciones a la vista 'orders.index'
        return view('dashboard', compact('orders'));
    }
}
