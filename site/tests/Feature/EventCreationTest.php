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
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EventCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_creation_page_loads_correctly()
    {
        // Simula la carga de la página de creación de eventos
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/crear-esdeveniment');
        $response->assertOk();
    }

    public function test_event_creation_with_valid_data()
    {
        $file = UploadedFile::fake()->create('logo.png');

        $user = User::factory()->create(); // Crea un usuario para asociar al evento
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $form = [
            'user_id' => $user->id,
            'titol' => 'Evento de Prueba',
            'categoria' => 1,
            'recinte' => $recinte->id,
            'imatge' => [$file],
            'descripcio' => 'Descripción del evento de prueba',
            'data_hora' => '2024-02-28 12:00:00',
            'dataHoraPersonalitzada' => '2024-02-28 12:00:00',
            'aforament_maxim' => 100,
            'entrades-nom' => ['general', 'vip'],
            'entrades-preu' => [90, 150],
            'entrades-quantitat' => [100, 50],
            'entradaNominalCheck' => [false, false],
        ];
        // Simula el envío de un formulario con datos válidos
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('crear-esdeveniment.store', $form);
        $response->assertRedirect('/homePromotor');

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'Evento de Prueba']);
        $this->assertDatabaseHas('sessios', ['data' => '2024-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'vip']);
    }

    public function test_recinte_page_loads(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('crear-recinte');
        $response->assertOk();
    }

    public function test_recinte_creation_with_valid_data(){
        $user = User::factory()->create();

        $form = [
            'nova_carrer' => 'Carretera de Montcada',
            'nova_numero' => 30,
            'nova_nom' => 'Recinte prova',
            'nova_provincia' => 'Barcelona',
            'nova_ciutat' => 'Terrassa',
            'nova_codi_postal' => '08223',
            'nova_capacitat' => 100,
            'nova_user_id' => $user->id,
        ];

        $url = 'recinte-nou?' . http_build_query($form);
        
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get($url);
        $response->assertRedirect('crear-esdeveniment');
    }

    public function test_recinte_creation_fails(){
        $user = User::factory()->create();

        $form = [
            'nova_carrer' => 'asdshdsaahdjahajdadasdadsadsadsadasdaaddasdajdajdsj',
            'nova_numero' => 2134242432488724987237492929292927482,
            'nova_nom' => 'Recinte prova',
            'nova_provincia' => 'Barcelona',
            'nova_ciutat' => 'Terrassa',
            'nova_codi_postal' => '08223',
            'nova_capacitat' => 100,
            'nova_user_id' => $user->id,
        ];

        $url = 'recinte-nou?' . http_build_query($form);
        
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get($url);
        $response->assertRedirect('crear-esdeveniment');
    }
}
