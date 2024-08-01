{{-- resources/views/newproduct.blade.php --}}
<x-main-alter>
    <x-header />
    <main class="p-10">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Agregar Nuevo Producto</h1>

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

            {{-- Formulario para agregar un nuevo producto --}}
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Nombre</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700">Precio</label>
                    <input type="number" name="price" id="price" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700">Categoría</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="images" class="block text-gray-700">Imágenes</label>
                    <input type="file" name="images[]" id="images" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" multiple accept="image/*">
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Agregar Producto
                </button>

            </form>
        </div>
    </main>
    <x-footer />
</x-main-alter>
