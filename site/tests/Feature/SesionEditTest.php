<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Recinte;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use App\Models\EsdevenimentImatge;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Assert;
use Illuminate\Support\Facades\Log;


class SesionEditTest extends TestCase
{
    use RefreshDatabase;

    //Test que valida la carga de la página añadir sesión
    public function test_anadir_sessio_page_loads_correctly()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/añadirSession');
        $response->assertOk();
    }

    //Test que valida la subida de una nueva sesión a la bd
    public function test_anadir_session_validate()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => $categoria->id,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);

        //Datos de la nueva sesión
        $form = [
            'event-id' => $esdeveniment->id,
            'user_id' => $user->id,
            'data_hora' => '2024-02-28 12:00:00',
            'dataHoraPersonalitzada' => '2024-02-28 12:00:00',
            'aforament_maxim' => 100,
            'entrades-nom' => ['general', 'vip'],
            'entrades-preu' => [90, 150],
            'entrades-quantitat' => [100, 50],
            'entradaNominalCheck' => [True, False],
        ];

        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/peticionSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }

    public function test_anadir_entrada_exception()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => $categoria->id,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);

        //Datos de la nueva sesión
        $form = [
            'event-id' => $esdeveniment->id,
            'user_id' => $user->id,
            'data_hora' => '2024-02-28 12:00:00',
            'dataHoraPersonalitzada' => '2024-02-28 12:00:00',
            'aforament_maxim' => 100,
            'entradaNominal' => True,
            'entrades-nom' => ['general', 'vip'],
            'entrades-preu' => [90, 150],
            'entrades-quantitat' => [100, 50],
        ];

        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/peticionSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }

    public function test_update_session_page_load()
    {
        //Creación de un evento para poder editar una sesión
        $user = User::factory()->create([
            'tipus' => 'Promotor',
        ]);
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

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
            'eventoId' => $esdeveniment1->id,
            'fechaId' => $sessio1->id,
        ];

        $queryString = http_build_query($form);

        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/editarSesion?' . $queryString);
        $response->assertOk();
    }



    //Al editar la sesón podes añadir, quitar o editar las entradas. Se crearon test para cada caso posible en cuanto a las entradas
    //y se editan las otras partes de las sesiones para confirmar que todo funciona.
    public function test_editar_session_edit_entrada_validate()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id' => $esdeveniment->id,
        ]);
        $entrada = Entrada::factory()->create([
            'sessios_id' => $sessio->id,
        ]);

        $form = [
            'event-id' => $esdeveniment->id,
            'fecha-id' => $sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 50,
            'entradaNominal' => False,
            'entrades-nom' => ['normal', 'vip+'],
            'entrades-preu' => [20, 100],
            'entrades-quantitat' => [25, 25],
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/cambiarSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }
    public function  test_editar_session_mas_entrada_validate()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id' => $esdeveniment->id,
        ]);
        $entrada = Entrada::factory()->create([
            'nom' => 'normal',
            'preu' => 20,
            'quantitat' => 100,
            'nominal' => False,
            'sessios_id' => $sessio->id,
        ]);

        $form = [
            'event-id' => $esdeveniment->id,
            'fecha-id' => $sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 400,
            'entrades-nom' => ['normal', 'normal+', 'vip+', 'vip'],
            'entrades-preu' => [20, 30, 100, 200],
            'entrades-quantitat' => [100, 100, 100, 100],
            'entradaNominalCheck' => [False, False, False, False],
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/cambiarSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }
    public function test_editar_session_entrada_exception()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id' => $esdeveniment->id,
        ]);
        $entrada = Entrada::factory()->create([
            'sessios_id' => $sessio->id,
        ]);

        $form = [
            'event-id' => $esdeveniment->id,
            'fecha-id' => $sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 150,
            'entradaNominal' => False,
            'entrades-nom' => ['normal'],
            'entrades-preu' => [15],
            'entrades-quantitat' => [150],
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/cambiarSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }
    public function test_editar_session_menos_entrada_validate()
    {
        //Creación de un evento para poder añadirle una sesión
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);
        $esdeveniment = Esdeveniment::factory()->create([
            'user_id' => $user->id,
            'id' => 1,
            'categoria_id' => $categoria->id,
            'recinte_id' => $recinte->id,
        ]);
        $sessio = Sessio::factory()->create([
            'esdeveniments_id' => $esdeveniment->id,
        ]);

        $entrada1 = Entrada::factory()->create([
            'nom' => 'normal',
            'preu' => 15,
            'quantitat' => 150,
            'nominal' => False,
            'sessios_id' => $sessio->id,
        ]);

        $entrada2 = Entrada::factory()->create([
            'nom' => 'vip',
            'preu' => 30,
            'quantitat' => 100,
            'nominal' => True,
            'sessios_id' => $sessio->id,
        ]);

        $form = [
            'event-id' => $esdeveniment->id,
            'fecha-id' => $sessio->id,
            'user_id' => $user->id,
            'data_hora' => '2024-04-18 13:30:00',
            'dataHoraPersonalitzada' => '2024-04-18 10:00:00',
            'aforament_maxim' => 150,
            'entrades-nom' => ['normal'],
            'entrades-preu' => [15],
            'entrades-quantitat' => [150],
            'entradaNominalCheck' => [False],
        ];
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('/cambiarSesion', $form);
        $response->assertRedirect('/editarEsdeveniment/' . $esdeveniment->id);
    }
}
