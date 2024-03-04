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
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class OpinionTest extends TestCase
{
    use RefreshDatabase;

    public function test_opinion_creation_page_loads_correctly()
    {

        $user = User::factory()->create();

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorias existentes

        $esdeveniment1 = Esdeveniment::factory()->create([
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);
    
        // Simula la carga de la página de creación de eventos
        $form = [
            'event-id' => $esdeveniment1->id,
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('crearOpinion', $form);
        $response->assertOk();
    }

    public function test_opinion_creation()
    {
        $user = User::factory()->create();

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorias existentes

        $esdeveniment1 = Esdeveniment::factory()->create([
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        $form = [
            'nombre' => 'opinion de prueba',
            'valoracion' => '😠',
            'puntuacion' => '5',
            'titulo' => 'titulo opinion',
            'comentario' => 'comentario de prueba',
            'event-id' => $esdeveniment1->id,
        ];
        // Simula el envío de un formulario con datos válidos
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('crearOpinion.store', $form);
        $response->assertRedirect('/esdeveniment/'.$esdeveniment1->id);
    }
}
