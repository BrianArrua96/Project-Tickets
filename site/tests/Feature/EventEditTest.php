<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\Recinte;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EsdevenimentImatge;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Opinion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EventEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_event_page_loads()
    {

        $user = User::factory()->create();

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'nom' => 'Recinte prova',
            'provincia' => 'Barcelona',
            'lloc' => 'Terrassa',
            'codi_postal' => '08223',
            'capacitat' => 100,
            'carrer' => 'Carretera de Montcada',
            'numero' => 30,
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorias existentes

        $esdeveniment1 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment1',
            'descripcio' => 'descripcio prova',
            'ocult' => false,
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        EsdevenimentImatge::factory()->create([
            'esdeveniments_id' => $esdeveniment1->id,
            'imatge' => UploadedFile::fake()->create('logo.png'),
        ]);

        $sessio1 = Sessio::factory()->create([
            'data' => '2025-02-28 12:00:00',
            'aforament' => 100,
            'tancament' => '2025-02-28 12:00:00',
            'esdeveniments_id' => $esdeveniment1->id,
        ]);

        Entrada::factory()->create([
            'nom' => 'general',
            'preu' => 100,
            'quantitat' => 100,
            'nominal' => false,
            'sessios_id' => $sessio1->id,
        ]);

        $opinion = Opinion::factory()->create([
            'nom' => 'Opinio',
            'emocio' => 3,
            'puntuacio' =>3,
            'titol' => 'Opinio event',
            'comentari' => 'comentario del evento',
            'esdeveniment_id' => $esdeveniment1->id,
        ]);

        $response = $this->get('/editarEsdeveniment/' . $esdeveniment1->id);
        $response->assertOk();
    }
}
