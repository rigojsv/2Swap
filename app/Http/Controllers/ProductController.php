<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('newproduct', compact('categories'));
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'nullable|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Maneja la carga de archivos de imágenes
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('public/images');
                $imagePaths[] = Storage::url($imagePath);
            }
        }

        // Crea un nuevo producto en la base de datos con el user_id autenticado
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'images' => json_encode($imagePaths),
        ]);

        // Guarda el producto en la sesión para el proceso de pago
        session(['product' => $product]);

        // Redirige a la página de pago
        return Redirect::route('payment.page');
    }

    public function showPaymentPage()
{
    if (!session()->has('product')) {
        return redirect()->route('product.create');
    }

    $product = session('product');

    // Determinar el monto basado en el rango de precio;
    $price = $product->price;
    $amount = $this->calculateAmount($price);

    return view('payment', compact('product', 'amount'));
}

private function calculateAmount($price)
{
    if ($price <= 100) {
        return 10;
    } elseif ($price > 100 && $price <= 500) {
        return 50;
    } elseif ($price > 500 && $price <= 1000) {
        return 100;
    } elseif ($price > 1000 && $price <= 10000) {
        return 500;
    } else {
        return 1000;  // Por defecto para precios mayores a 10000
    }
}


    public function processPayment(Request $request)
    {
        if (!session()->has('product')) {
            return redirect()->route('product.create');
        }

        $product = session('product');

        // Validar datos del formulario de pago
        $request->validate([
            'cardholder_name' => 'required|string|max:100',
            'card_number' => 'required|string|size:16',  // Considera usar una validación más estricta para números de tarjeta
            'expiry_date' => 'required|string|size:5',
            'cvv' => 'required|string|size:3',
            'price_range' => 'required|integer',
        ]);

        // Determinar el monto basado en el rango de precio
        $priceRanges = [
            1 => 10,
            2 => 50,
            3 => 100,
            4 => 500,
        ];

        $selectedRange = $request->input('price_range');
        $amount = $priceRanges[$selectedRange] ?? 0;

        // Simular el proceso de pago aquí
        $pago_exitoso = true;  // Cambia esto por la lógica real de pago

        if ($pago_exitoso) {
            session()->forget('product');
            return redirect()->route('product.create')->with('success', 'Producto publicado con éxito! Pago de L ' . number_format($amount, 2) . ' realizado.');
        } else {
            return redirect()->route('payment.page')->with('error', 'Error en el pago.');
        }
    }
}
