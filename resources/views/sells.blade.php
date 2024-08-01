<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis ventas') }}
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
                    @forelse($sales as $sale)
                        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $sale->product->name }}</h3>
                                <p class="text-gray-600 mt-2">Fecha: {{ $sale->created_at->format('d/m/Y') }}</p>
                                <p class="text-gray-700 mt-4">{{ Str::limit($sale->product->description, 100, '...') }}</p>
                                <p class="text-sm font-semibold">Monto: L. {{ number_format($sale->amount, 2) }}</p>
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