<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Opinion;
use App\Models\Esdeveniment;

class OpinionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $esdevenimentIds = Esdeveniment::pluck('id');

        Opinion::factory()->count(10)->create([
            'esdeveniments_id' => function () use ($esdevenimentIds) {
                return rand(1, count($esdevenimentIds));
            },
        ]);
    }
}
