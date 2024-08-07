<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                <div class="bg-green-500 text-white p-4 mb-4 rounded-md shadow-md">
                    {{ session('success') }}
                </div>
                @endif
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($sales as $sale)
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                        <!-- Imagen del producto -->
                        @if (!empty(json_decode($sale->product->images)[0]))
                            <img src="{{ json_decode($sale->product->images)[0] }}" alt="{{ $sale->product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                        @else
                            <img src="default-image.jpg" alt="{{ $sale->product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                        @endif

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $sale->product->name }}</h3>
                            <p class="text-gray-600 mt-2">Fecha: {{ $sale->created_at->format('d/m/Y') }}</p>
                            <p class="text-gray-700 mt-1">{{ Str::limit($sale->product->description, 100, '...') }}</p>
                            <p class="font-semibold mt-1">Monto: L. {{ number_format($sale->total, 2) }}</p>
                            @if($sale->status !== 'delivered')
                            <p class="font-semibold mt-1">Direccion</p>
                            <p class="text-sm ">{{$sale->instructions}}, {{$sale->address}}</p>
                            <a href="https://wa.me/{{$sale->phone}}?text=Hola%2C%20te%20saludo%20de%202Swap%20por%20el%20producto%20{{ urlencode($sale->product->name) }}%20¡coordinemos%20la%20entrega!" target="_blank" class="mt-4 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition">
                                <i class="fab fa-whatsapp mr-2"></i> Contactar 
                            </a>
                            @else
                            <p class="border border-green-500 text-green-500 mt-4 px-4 py-2 rounded-md font-bold inline-block">
                                Pedido entregado
                            </p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500">No hay ventas realizadas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>