<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Esdeveniment;
use App\Models\Sessio;
use App\Models\Recinte;
use App\Models\Categoria;
use App\Models\Entrada;
use App\Models\EsdevenimentImatge;
use Illuminate\Http\UploadedFile;

class MostrarEventsAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_view_with_events_admin()
    {
        $user = User::factory()->create([
            "name" => "promotor1",
            "username" => "promotor1",
            "password" => "p12345678",
            "email" => "promotor1@gmail.com",
            "tipus" => "Promotor",
        ]);

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
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
        
        $form = [
            'user_id' => $user->id,
        ];
        // Simula la carga de la página de listado de sesiones
        $response = $this->actingAs($user)->withSession(['key' => $user->id, 'user_id' => $user->id])->post('administrar-esdeveniments', $form);

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'esdeveniment1']);
        $this->assertDatabaseHas('sessios', ['data' => '2025-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'general']);

        // Verifica que la página se cargue correctamente y que se pasen las sesiones a la vista
        $response->assertOk();
        //$response->assertViewHas('sesiones');
        $response->assertSeeText($esdeveniment1->nom);
    }
}
