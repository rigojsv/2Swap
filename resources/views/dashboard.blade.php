<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4 rounded-md shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($orders as $order)
                        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            <!-- Imagen del producto -->
                            @if (!empty(json_decode($order->product->images)[0]))
                                <img src="{{ json_decode($order->product->images)[0] }}" alt="{{ $order->product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                            @else
                                <img src="default-image.jpg" alt="{{ $order->product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                            @endif

                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $order->product->name }}</h3>
                                <p class="text-gray-600 mt-2">Fecha: {{ $order->created_at->format('d/m/Y') }}</p>
                                <p class="text-gray-700 mt-1">{{ Str::limit($order->product->description, 100, '...') }}</p>
                                <p class="font-semibold mt-1">Monto: L. {{ number_format($order->total, 2) }}</p>
                                @if($order->status !== 'delivered')
                                <p class="text-sm">Pronto {{$order->user->name}} comunicara contigo para coordinar la entrega.</p>
                                <form action="{{ route('order.markReceived', $order->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Marcar como recibido
                                    </button>
                                </form>
                            @else
                            <p class="border border-green-500 text-green-500 mt-4 px-4 py-2 rounded-md font-bold inline-block">
                                Pedido recibido
                            </p>
                            @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">No hay pedidos realizados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>