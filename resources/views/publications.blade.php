<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis publicaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Botón para crear una nueva publicación -->
                <div class="flex justify-end mb-4">
                    <a href="{{ route('product.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Crear nueva publicación
                    </a>
                </div>

                <!-- Lista de publicaciones -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Repetir este bloque para cada publicación -->
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                        <img src="ruta-de-la-imagen-del-producto.jpg" alt="Nombre del producto" class="w-full h-32 object-cover rounded-t-lg">
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800">Título de la Publicación</h3>
                            <p class="text-gray-600 mt-2">Fecha: 31/07/2024</p>
                            <p class="text-gray-700 mt-4">Descripción corta de la publicación...</p>
                            <a href="#" class="text-blue-500 hover:text-blue-700 mt-4 inline-block">Leer más</a>
                        </div>
                    </div>
                    <!-- Fin del bloque repetible -->
                </div>
                <!-- Fin de la lista de publicaciones -->
            </div>
        </div>
    </div>
</x-app-layout>

