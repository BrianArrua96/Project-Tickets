<?php

namespace Database\Seeders;

// database/seeders/CategoriesTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verificar si las categorías ya existen
        $existingCategories = Categoria::whereIn('tipus', ['social', 'cultural', 'deportivo', 'empresarial', 'académico', 'recaudación', 'religioso', 'político', 'privado', 'otros'])->pluck('tipus')->toArray();

        // Crear solo las categorías que no existen
        $categoriesToCreate = array_diff(['social', 'cultural', 'deportivo', 'empresarial', 'académico', 'recaudación', 'religioso', 'político', 'privado', 'otros'], $existingCategories);

        foreach ($categoriesToCreate as $category) {
            Categoria::factory()->create(['tipus' => $category]);
        }
    }
}

