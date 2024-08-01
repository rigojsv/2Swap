{{-- resources/views/payment.blade.php --}}
<x-main-alter>
    <x-header />
    <main class="p-10">
        <div class="container mx-auto flex flex-col md:flex-row p-4 max-w-7xl">
            <div class="w-full md:w-2/3 pr-4">
                <h1 class="text-2xl font-bold mb-4">Detalles de Pago</h1>

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

            
            {{-- Formulario de pago --}}
            <form action="{{ route('payment.process') }}" method="POST">
                @csrf

                <input type="hidden" name="price_range" value="{{ $amount }}">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold">Método de Pago</h2>
                    <div class="bg-gray-100 p-4 rounded-md">
                        <label for="cardholder_name" class="block text-gray-700 font-medium">Nombre del Titular</label>
                        <input type="text" name="cardholder_name" id="cardholder_name"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm px-3 py-2" required>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-md">
                        <label for="card-number" class="block text-gray-700">Número de Tarjeta</label>
                        <input type="text" name="card_number" id="card-number"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{16}"
                            maxlength="16" minlength="16" required>
                        <small class="text-gray-500">16 dígitos (solo números).</small>

                        <div class="flex gap-4 mt-4">
                            <div class="flex-1">
                                <label for="expiry-date" class="block text-gray-700">Fecha de Expiración</label>
                                <input type="text" name="expiry_date" id="expiry-date"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{2}/\d{2}"
                                    placeholder="MM/AA" required>
                                <small class="text-gray-500">Formato: MM/AA</small>
                            </div>

                            <div class="flex-1">
                                <label for="cvc" class="block text-gray-700">Código de Seguridad (CVC)</label>
                                <input type="text" name="cvc" id="cvc"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{3}"
                                    maxlength="3" required>
                                <small class="text-gray-500">3 dígitos.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 transition">Pagar</button>
                <a href="{{ route('product.create') }}"
                    class="bg-gray-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-600 transition ml-4">Cancelar</a>
            </form>
            </div>

            <div class="w-full md:w-1/3 bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-xl font-bold mb-4">Resumen del Pedido</h2>
                <div class="divide-y divide-gray-200">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center">
                            @if($product->images)
                            @php
                            $images = json_decode($product->images, true);
                            @endphp
                            @if(!empty($images) && is_array($images))
                            <img src="{{ $images[0] }}" class="w-16 h-16 object-cover rounded-md"
                                alt="{{ $product->name }}">
                            @endif
                            @endif
                            <div class="ml-4">
                                <p class="text-sm font-semibold">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $product->description }}</p>
                            </div>
                        </div>
                        <p><strong>Precio:</strong> L {{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="flex justify-between items-center py-4 font-semibold">
                        <p class="text-lg font-semibold">Monto a Pagar: L {{ number_format($amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</x-main-alter>