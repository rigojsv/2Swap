<!-- resources/views/paymentcart.blade.php -->
<x-main-alter>
    <x-header />
    <main class="p-10">
        <div class="container mx-auto flex flex-col md:flex-row p-4 max-w-7xl">
            <!-- Formulario de Pago -->
            <div class="w-full md:w-2/3 pr-4">
                <h1 class="text-2xl font-bold mb-4">Detalles de Pago</h1>

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Mensajes de éxito --}}
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Formulario de pago --}}
                <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nombre Completo</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-gray-700">Dirección</label>
                        <input type="text" name="address" id="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700">Número de Teléfono</label>
                        <input type="tel" name="phone" id="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="[0-9]{10}" required>
                        <small class="text-gray-500">Ingrese un número de teléfono válido (10 dígitos).</small>
                    </div>

                    <div class="mb-4">
                        <label for="zip" class="block text-gray-700">Código Postal</label>
                        <input type="text" name="zip" id="zip" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="[0-9]{5}" required>
                        <small class="text-gray-500">Ingrese un código postal válido (5 dígitos).</small>
                    </div>

                    <div class="mb-4">
                        <label for="instructions" class="block text-gray-700">Instrucciones de Entrega (Opcional)</label>
                        <textarea name="instructions" id="instructions" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="mb-4">
                        <h2 class="text-xl font-semibold">Método de Pago</h2>
                        <div class="bg-gray-100 p-4 rounded-md">
                            <label for="card-number" class="block text-gray-700">Número de Tarjeta</label>
                            <input type="text" name="card_number" id="card-number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{16}" maxlength="16" minlength="16" required>
                            <small class="text-gray-500">16 dígitos (solo números).</small>

                            <div class="flex gap-4 mt-4">
                                <div class="flex-1">
                                    <label for="expiry-date" class="block text-gray-700">Fecha de Expiración</label>
                                    <input type="text" name="expiry_date" id="expiry-date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{2}/\d{2}" placeholder="MM/AA" required>
                                    <small class="text-gray-500">Formato: MM/AA</small>
                                </div>

                                <div class="flex-1">
                                    <label for="cvc" class="block text-gray-700">Código de Seguridad (CVC)</label>
                                    <input type="text" name="cvc" id="cvc" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" pattern="\d{3}" maxlength="3" required>
                                    <small class="text-gray-500">3 dígitos.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                        Procesar Pago
                    </button>
                </form>
            </div>

            <!-- Resumen del Pedido -->
            <div class="w-full md:w-1/3 bg-white shadow-lg rounded-lg p-4">
                <h2 class="text-xl font-bold mb-4">Resumen del Pedido</h2>
                <div class="divide-y divide-gray-200">
                    @if ($cart && $cart->items->count() > 0)
                        @foreach($cart->items as $item)
                            <div class="flex justify-between items-center py-4">
                                <div class="flex items-center">
                                    @if($item->product->images)
                                        @php
                                            $images = json_decode($item->product->images, true);
                                        @endphp
                                        @if(!empty($images) && is_array($images))
                                            <img src="{{ $images[0] }}" class="w-16 h-16 object-cover rounded-md" alt="{{ $item->product->name }}">
                                        @endif
                                    @endif
                                    <div class="ml-4">
                                        <p class="text-sm font-semibold">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->product->description }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-semibold">L. {{ number_format($item->product->price * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach

                        <div class="flex justify-between items-center py-4 font-semibold">
                            <span>Total:</span>
                            <span>L. {{ number_format($cart->items->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</span>
                        </div>
                    @else
                        <p class="text-center text-gray-500">No hay artículos en el carrito.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</x-main-alter>
