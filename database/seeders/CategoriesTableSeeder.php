<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Electrónica',
            'Ropa',
            'Libros',
            'Hogar y Cocina',
            'Deportes y Aire Libre',
            'Juguetes y Juegos',
            'Belleza y Cuidado Personal',
            'Salud y Hogar',
            'Automotriz',
            'Jardín y Exterior',
            'Suministros para Mascotas',
            'Supermercado',
            'Productos de Oficina',
            'Herramientas y Mejoras del Hogar',
            'Artes, Manualidades y Costura',
            'Música',
            'Películas y TV',
            'Videojuegos',
            'Joyería',
            'Zapatos y Bolsos',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
