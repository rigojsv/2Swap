<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis publicaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Mensajes de éxito -->
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 mb-4 rounded-md shadow-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Botón para crear una nueva publicación -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('product.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Crear nueva publicación
                    </a>
                </div>

                <!-- Lista de publicaciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            @if (!empty(json_decode($product->images)[0]))
                                <img src="{{ json_decode($product->images)[0] }}" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                            @else
                                <img src="default-image.jpg" alt="{{ $product->name }}" class="w-full h-32 object-cover rounded-t-lg">
                            @endif
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-600 mt-2">Fecha: {{ \Carbon\Carbon::parse($product->publication_date)->format('d/m/Y') }}</p>
                                <p class="text-gray-700 mt-4">{{ Str::limit($product->description, 100, '...') }}</p>
                                <a href="#" class="text-blue-500 hover:text-blue-700 mt-4 inline-block">Leer más</a>

                                <!-- Botón de eliminar -->
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="mt-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Fin de la lista de publicaciones -->
            </div>
        </div>
    </div>
</x-app-layout>
