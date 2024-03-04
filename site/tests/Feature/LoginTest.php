<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Sessio;
use App\Models\Entrada;
use App\Models\Recinte;
use App\Models\Categoria;
use App\Models\Esdeveniment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    //Test el cual valida la carga de la página login

    public function test_home_promotor_loads_correctly()
    {
        $user = User::factory()->create([
            'username' => 'promotor1',
            'password' => Hash::make('p12345678'),
            "tipus" => "Promotor",
        ]);

        $response = $this->actingAs($user)->withSession(['key' => $user->id])->get('/homePromotor');
        $response->assertOk();
    }

    public function test_login_page_loads_correctly()
    {
        $response = $this->get('/login');
        $response->assertOk();
    }

    //Test que valida el acceso a usuarios desde el login
    public function test_login_validates_users()
    {
        $user = User::factory()->create([
            'username' => 'promotor1',
            'password' => Hash::make('p12345678'),
            "tipus" => "Promotor",
        ]);
        $credentials = [
            'usuario' => 'promotor1',
            'password' => 'p12345678',
        ];
        $response = $this->post('/iniciarSesion', $credentials);
        $response->assertRedirect('/homePromotor');
    }

    //Test que valida el acceso a usuarios desde el login
    public function test_login_fails_correctly()
    {
        $user = User::factory()->create([
            'username' => 'promotor1',
            'password' => Hash::make('p12345678'),
            "tipus" => "Promotor",
        ]);
        $credentials = [
            'usuario' => 'prueba',
            'password' => '1234',
        ];
        $response = $this->post('/iniciarSesion', $credentials);
        $response->assertRedirect('/login');
    }

    //Test que valida el acceso a usuarios desde el login
    public function test_empty_fails_correctly()
    {
        $user = User::factory()->create([
            'username' => 'promotor1',
            'password' => Hash::make('p12345678'),
            "tipus" => "Promotor",
        ]);
        $credentials = [
            'usuario' => 'prueba',
        ];
        $response = $this->post('/iniciarSesion', $credentials);
        $response->assertRedirect('/login');
    }

    //Test que valida el acceso a usuarios desde el login
    public function test_login_validates_admin()
    {
        $user = User::factory()->create([
            'username' => 'promotor2',
            'password' => Hash::make('p12345678'),
            "tipus" => "Admin",
        ]);
        $credentials = [
            'usuario' => 'promotor2',
            'password' => 'p12345678',
        ];
        $response = $this->post('/iniciarSesion', $credentials);
        $response->assertOk();
    }
}