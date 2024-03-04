<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Esdeveniment;
use App\Models\Recinte;
use App\Models\Categoria;

class EsdevenimentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs de recintos y categorias existentes
        $recintesIds = Recinte::pluck('id');
        $categoriesIds = Categoria::pluck('id');

        Esdeveniment::factory()->count(10)->create([
            'recinte_id' => function () use ($recintesIds) {
                return rand(1, count($recintesIds));
            },
            'categoria_id' => function () use ($categoriesIds) {
                return rand(1, count($categoriesIds));
            },
        ]);
    }
}
