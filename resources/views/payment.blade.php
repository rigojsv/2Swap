{{-- resources/views/payment.blade.php --}}
<x-main-alter>
    <x-header />
    <main class="p-10">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Confirmar Pago</h1>

            {{-- Mensajes de error --}}
            @if (session('error'))
                <div class="bg-red-500 text-white p-4 mb-4 rounded-md shadow-md">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Mensajes de éxito --}}
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-md shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Información del producto --}}
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Detalles del Producto</h2>
                <p><strong>Nombre:</strong> {{ $product->name }}</p>
                <p><strong>Descripción:</strong> {{ $product->description }}</p>
                <p><strong>Precio:</strong> L {{ number_format($product->price, 2) }}</p>

                {{-- Mostrar la imagen del producto --}}
                @if (!empty(json_decode($product->images)[0]))
                    <div class="mt-4" style="width: 500px; height: auto;">
                        <img src="{{ json_decode($product->images)[0] }}" alt="Imagen del producto" class="w-full h-auto border border-gray-300 rounded-md shadow-md">
                    </div>
                @endif
            </div>

            {{-- Mostrar el monto a pagar --}}
            <div class="mb-6">
                <p class="text-lg font-semibold">Monto a Pagar: L {{ number_format($amount, 2) }}</p>
            </div>

            {{-- Formulario de pago --}}
            <form action="{{ route('payment.process') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="cardholder_name" class="block text-gray-700 font-medium">Nombre del Titular</label>
                    <input type="text" name="cardholder_name" id="cardholder_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="card_number" class="block text-gray-700 font-medium">Número de Tarjeta</label>
                    <input type="text" name="card_number" id="card_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="expiry_date" class="block text-gray-700 font-medium">Fecha de Expiración (MM/AA)</label>
                    <input type="text" name="expiry_date" id="expiry_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" required>
                </div>

                <div class="mb-4">
                    <label for="cvv" class="block text-gray-700 font-medium">CVV</label>
                    <input type="text" name="cvv" id="cvv" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" required>
                </div>

                <input type="hidden" name="price_range" value="{{ $amount }}">

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition">Pagar</button>
                <a href="{{ route('product.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600 transition ml-4">Cancelar</a>
            </form>
        </div>
    </main>
    <x-footer />
</x-main-alter>