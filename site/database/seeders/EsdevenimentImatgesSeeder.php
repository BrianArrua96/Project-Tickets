<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EsdevenimentImatge;
use App\Models\Esdeveniment;

class EsdevenimentImatgesSeeder extends Seeder
{
    public function run()
    {
        $esdevenimentIds = Esdeveniment::pluck('id');

        EsdevenimentImatge::factory()->count(10)->create([
            'esdeveniments_id' => function () use ($esdevenimentIds) {
                return rand(1, count($esdevenimentIds));
            },
        ]);
    }
}