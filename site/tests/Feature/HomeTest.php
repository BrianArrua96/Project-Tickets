<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recinte;
use App\Models\Esdeveniment;
use App\Models\Categoria;
use App\Models\EsdevenimentImatge;
use App\Models\User;
use App\Models\Sessio;
use App\Models\Entrada;
use Illuminate\Http\UploadedFile;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_correctly()
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSeeText("No se ha encontrado ningún evento.");
    }

    public function test_compra_page_to_home_loads_correctly()
    {

        $user = User::factory()->create();

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

        $esdeveniment2 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment2',
            'descripcio' => 'descripcio prova',
            'ocult' => false,
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        EsdevenimentImatge::factory()->create([
            'esdeveniments_id' => $esdeveniment2->id,
            'imatge' => UploadedFile::fake()->create('logo.png'),
        ]);

        $sessio2 = Sessio::factory()->create([
            'data' => '2026-02-28 12:00:00',
            'aforament' => 100,
            'tancament' => '2026-02-28 12:00:00',
            'esdeveniments_id' => $esdeveniment2->id,
        ]);

        Entrada::factory()->create([
            'nom' => 'vip',
            'preu' => 100,
            'quantitat' => 100,
            'nominal' => false,
            'sessios_id' => $sessio2->id,
        ]);

        $esdeveniment3 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment3',
            'descripcio' => 'descripcio prova',
            'ocult' => false,
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        EsdevenimentImatge::factory()->create([
            'esdeveniments_id' => $esdeveniment3->id,
            'imatge' => UploadedFile::fake()->create('logo.png'),
        ]);

        $sessio3 = Sessio::factory()->create([
            'data' => '2027-02-28 12:00:00',
            'aforament' => 100,
            'tancament' => '2027-02-28 12:00:00',
            'esdeveniments_id' => $esdeveniment3->id,
        ]);

        Entrada::factory()->create([
            'nom' => 'publica',
            'preu' => 100,
            'quantitat' => 100,
            'nominal' => false,
            'sessios_id' => $sessio3->id,
        ]);

        $compra = true;

        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/home/'. $compra);
        $response->assertOk();

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'esdeveniment1']);
        $this->assertDatabaseHas('sessios', ['data' => '2025-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'general']);

        $response->assertSeeText($esdeveniment1->nom);
        $response->assertSeeText($esdeveniment2->nom);
        $response->assertSeeText($esdeveniment3->nom);
    }

    public function test_event_loads_correctly()
    {
        $user = User::factory()->create();

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

        $esdeveniment2 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment2',
            'descripcio' => 'descripcio prova',
            'ocult' => false,
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        EsdevenimentImatge::factory()->create([
            'esdeveniments_id' => $esdeveniment2->id,
            'imatge' => UploadedFile::fake()->create('logo.png'),
        ]);

        $sessio2 = Sessio::factory()->create([
            'data' => '2026-02-28 12:00:00',
            'aforament' => 100,
            'tancament' => '2026-02-28 12:00:00',
            'esdeveniments_id' => $esdeveniment2->id,
        ]);

        Entrada::factory()->create([
            'nom' => 'vip',
            'preu' => 100,
            'quantitat' => 100,
            'nominal' => false,
            'sessios_id' => $sessio2->id,
        ]);

        $esdeveniment3 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment3',
            'descripcio' => 'descripcio prova',
            'ocult' => false,
            'recinte_id' => $recinte->id,
            'categoria_id' => $categoria->id,
            'user_id' => $user->id,
        ]);

        EsdevenimentImatge::factory()->create([
            'esdeveniments_id' => $esdeveniment3->id,
            'imatge' => UploadedFile::fake()->create('logo.png'),
        ]);

        $sessio3 = Sessio::factory()->create([
            'data' => '2027-02-28 12:00:00',
            'aforament' => 100,
            'tancament' => '2027-02-28 12:00:00',
            'esdeveniments_id' => $esdeveniment3->id,
        ]);

        Entrada::factory()->create([
            'nom' => 'publica',
            'preu' => 100,
            'quantitat' => 100,
            'nominal' => false,
            'sessios_id' => $sessio3->id,
        ]);

        $response = $this->get('/');
        $response->assertOk();

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'esdeveniment1']);
        $this->assertDatabaseHas('sessios', ['data' => '2025-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'general']);

        $response->assertSeeText($esdeveniment1->nom);
        $response->assertSeeText($esdeveniment2->nom);
        $response->assertSeeText($esdeveniment3->nom);
    }

    public function test_search_filter_works_correctly()
    {
        $keyword = 'keyword_with_valid_results';
        $user = User::factory()->create();

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorias existentes

        $esdeveniment1 = Esdeveniment::factory()->create([
            'nom' => $keyword,
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
            'q' => $keyword,
            'category' => '',
        ];

        $response = $this->get('cerca', $form);

        // Verifica que la respuesta sea 200 OK
        $response->assertOk();

        $this->assertDatabaseHas('esdeveniments', ['nom' => $keyword]);
        $this->assertDatabaseHas('sessios', ['data' => '2025-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'general']);

        $response->assertSeeText($esdeveniment1->nom);
    }

    public function test_category_filter_works_correctly()
    {
        $user = User::factory()->create();

        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorias existentes

        $esdeveniment1 = Esdeveniment::factory()->create([
            'nom' => 'esdeveniment categoria',
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
            'category' => $categoria->id,
        ];

        $response = $this->get('cerca', $form);

        // Verifica que la respuesta sea 200 OK
        $response->assertOk();

        $this->assertDatabaseHas('esdeveniments', ['nom' => 'esdeveniment categoria']);
        $this->assertDatabaseHas('sessios', ['data' => '2025-02-28 12:00:00']);
        $this->assertDatabaseHas('entradas', ['nom' => 'general']);

        $response->assertSeeText($esdeveniment1->nom);
    }

    public function test_pagination_works_correctly()
    {
        $user = User::factory()->create();
        $categoria = Categoria::factory()->create();
        $recinte = Recinte::factory()->create([
            'user_id' => $user->id,
        ]);

        // Obtener IDs de recintos y categorías existentes

        for ($i = 1; $i <= 10; $i++) {
            $esdeveniment = Esdeveniment::factory()->create([
                'nom' => 'esdeveniment categoria ' . $i,
                'descripcio' => 'descripcio prova',
                'ocult' => false,
                'recinte_id' => $recinte->id,
                'categoria_id' => $categoria->id,
                'user_id' => $user->id,
            ]);

            EsdevenimentImatge::factory()->create([
                'esdeveniments_id' => $esdeveniment->id,
                'imatge' => UploadedFile::fake()->create('logo.png'),
            ]);

            $sessio = Sessio::factory()->create([
                'data' => '2025-02-28 12:00:00',
                'aforament' => 100,
                'tancament' => '2025-02-28 12:00:00',
                'esdeveniments_id' => $esdeveniment->id,
            ]);

            Entrada::factory()->create([
                'nom' => 'general',
                'preu' => 100,
                'quantitat' => 100,
                'nominal' => false,
                'sessios_id' => $sessio->id,
            ]);
        }


        $response = $this->get('/cerca?page=2');
        $response->assertOk();

        $response->assertSeeText('2');
        $response->assertDontSeeText('Mostrando 0 - 0 de 0 resultados');
    }
}
