<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class SalesController extends Controller
{
    public function index()
    {
        // Obtener las transacciones donde los productos pertenecen al usuario autenticado
        $sales = Transaction::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('sells', compact('sales'));
    }
}
