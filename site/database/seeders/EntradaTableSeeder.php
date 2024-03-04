<?php

namespace Database\Seeders;

use App\Models\Sessio;
use App\Models\Entrada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntradaTableSeeder extends Seeder
{
    public function run()
    {
        $sessioIds = Sessio::pluck('id');

        Entrada::factory()->count(2)->create([
            'sessios_id' => function () use ($sessioIds) {
                return rand(1, count($sessioIds));
            },
        ]);
    }
}
