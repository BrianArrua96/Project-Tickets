<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Recinte;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompraTest extends TestCase
{
  use RefreshDatabase;
  /**
   * A basic feature test example.
   */
  public function test_compra_page_loads_correctly()
  {

    $user = User::factory()->create(); // Crea un usuario para asociar al evento
    $categoria = Categoria::factory()->create();
    $recinte = Recinte::factory()->create([
      'user_id' => $user->id,
    ]);
    $event = Esdeveniment::factory()->create(
      [
        'nom' => 'Prueba',
        'recinte_id' => $recinte->id,
        'user_id' => $user->id,
        'categoria_id' => $categoria->id,
      ]
    );
    $session = Sessio::factory()->create(
      [
        'aforament' => 100,
        'estado' => true,
        'esdeveniments_id' => $event->id,
      ]
    );
    $entrada = Entrada::factory()->create(
      [
        'nom' => 'Entrada',
        'preu' => 100,
        'quantitat' => 100,
        'nominal' => false,
        'sessios_id' => $session->id,
      ]
    );
    $nomEvent = "Prueba";
    $entradaArray = [
      'session' => '2024-02-28 01:34:00',
      'nom' => 'prueva',
      'cantidad' => 1,
      'contadorSession' => 1,
      'contadorEntrada' => 1,
      'Maxcantidad' => 99,
      'precio' => 100,
      'nominal' => '2024-02-28 01:34:00',
    ];

    $response = $this->get(
      '/esdeveniment/1',
      [
        'entradaArray' => $entradaArray,
        'nomEvent' => $nomEvent,
        'sessionArray' => 1,
        'idEvent' => 1,
        'total' => 100,
      ]
    );
    $response->assertRedirect('/confirmacio');
  }
}
