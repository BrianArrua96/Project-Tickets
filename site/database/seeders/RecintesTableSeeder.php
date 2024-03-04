<?php

namespace Database\Seeders;

// database/seeders/RecintesTableSeeder.php

use Illuminate\Database\Seeder;
use App\Models\Recinte;
use App\Models\User;

class RecintesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();

        Recinte::factory()->count(5)->create([
            'user_id' => $users->random(),
        ]);
    }
}
