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

    // Almacena temporalmente el producto en la sesión
    $product = [
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'category_id' => $request->category_id,
        'user_id' => Auth::id(),
        'images' => json_encode($imagePaths),
    ];

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
    $product = (object) $product;
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

    $productData = session('product');
    
    // Validar datos del formulario de pago
    $request->validate([
        'cardholder_name' => 'required|string|max:100',
        'card_number' => 'required|string|size:16',  // Considera usar una validación más estricta para números de tarjeta
        'expiry_date' => 'required|string|size:5',
        'cvc' => 'required|string|size:3',
        'price_range' => 'required|integer',
    ]);

    $selectedRange = $request->input('price_range');
    // Simular el proceso de pago aquí
    $pago_exitoso = true;  // Cambia esto por la lógica real de pago

    if ($pago_exitoso) {
        // Si el pago es exitoso, guarda el producto en la base de datos
        $product = Product::create($productData);

        session()->forget('product');
        return redirect()->route('product.create')->with('success', 'Producto publicado con éxito! Pago de L ' . number_format($selectedRange, 2) . ' realizado.');
    } else {
        return redirect()->route('payment.page')->with('error', 'Error en el pago.');
    }
}

    public function myPublications()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Obtener los productos creados por el usuario
        $products = Product::where('user_id', $user->id)->get();

        // Pasar los productos a la vista
        return view('publications', compact('products'));
    }

    public function destroy($id)
{
    $user = auth()->user();
    $product = Product::where('user_id', $user->id)->findOrFail($id);

    // Eliminar el producto
    $product->delete();

    return redirect()->route('publications')->with('success', 'Publicación eliminada con éxito.');
}

public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all();
    return view('editproduct', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category_id' => 'required|exists:categories,id',
        // Agregar validaciones para otros campos si es necesario
    ]);

    $product = Product::findOrFail($id);

    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->category_id = $request->input('category_id');
    // Actualizar otros campos si es necesario

    $product->save();

    return redirect()->route('publications')->with('success', 'Producto actualizado con éxito.');
}

public function index()
{
    // Obtener productos con mejor calificación
    $topRatedProducts = Product::withCount('comments')
        ->withAvg('comments', 'rating')
        ->orderBy('comments_avg_rating', 'desc') // Ordenar por calificación promedio
        ->take(3) // Limitar a 3 productos
        ->get();

    return view('index', compact('topRatedProducts'));
}

}
