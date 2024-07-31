<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis pedidos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Tabla de pedidos -->
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">Imagen</th>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">ID del Pedido</th>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">Fecha</th>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">Estado</th>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">Total</th>
                            <th class="w-1/6 px-4 py-2 text-left text-gray-600 font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Repetir este bloque para cada pedido -->
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2">
                                <img src="ruta-de-la-imagen-del-producto.jpg" alt="Nombre del producto" class="w-16 h-16 object-cover rounded-lg">
                            </td>
                            <td class="px-4 py-2 text-gray-700">12345</td>
                            <td class="px-4 py-2 text-gray-700">31/07/2024</td>
                            <td class="px-4 py-2 text-gray-700">Completado</td>
                            <td class="px-4 py-2 text-gray-700">$50.00</td>
                            <td class="px-4 py-2 text-gray-700">
                                <a href="#" class="text-blue-500 hover:text-blue-700">Ver detalles</a>
                            </td>
                        </tr>
                        <!-- Fin del bloque repetible -->
                    </tbody>
                </table>
                <!-- Fin de la tabla de pedidos -->
            </div>
        </div>
    </div>
</x-app-layout>
