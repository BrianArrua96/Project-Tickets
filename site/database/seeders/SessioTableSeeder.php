<?php

namespace Database\Seeders;

use App\Models\Esdeveniment;
use App\Models\Sessio;
use Illuminate\Database\Seeder;

class SessioTableSeeder extends Seeder
{
    public function run()
    {
        $esdevenimentIds = Esdeveniment::pluck('id');

        Sessio::factory()->count(10)->create([
            'esdeveniments_id' => function () use ($esdevenimentIds) {
                return rand(1, count($esdevenimentIds));
            },
        ]);
    }
}
