<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery;
use App\Mail\CorreoRecuperar;

class RecuperarPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_recuperar_page_loads_correctly(): void
    {
        $response = $this->get('/recuperar');
        $response->assertOk();
    }
    public function test_recuperar_sends_email_correctly()
    {
        $user = User::factory()->create();
        $form = [
            'email' => $user->email,
        ];
        $response = $this->post('/recuperar-form', $form);
        $response->assertRedirect('/login');
    }

    public function test_page_password_fails()
    {
        $form = [
            'hasValidSignature' => false,
        ];
        // Test when URL is valid
        $response = $this->get('cambiarPassword', $form);
        $response->assertRedirect('/recuperar');
    }

    public function test_page_password()
    {

        // Crear un usuario para usar en la prueba
        $user = User::factory()->create();

        // Generar una URL firmada para la ruta 'cambiarPassword' con el ID del usuario
        $url = URL::temporarySignedRoute('cambiarPassword', now()->addMinutes(60), ['user' => $user->id]);

        // Realizar la solicitud a la URL firmada
        $response = $this->get($url);

        // Verificar que la página se cargue correctamente
        $response->assertOk('/login');
    }

    public function test_enviar_correo()
    {
        // Test when email exists
        $user = User::factory()->create();

        $response = $this->post('/recuperar-form', ['email' => $user->email]);
        $response->assertRedirect('login');

        // Test when email does not exist
        $response = $this->post('/recuperar-form', ['email' => 'nonexistent@example.com']);
        $response->assertRedirect('/login');
    }

    public function test_cambiar_password()
    {
        // Test when password meets requirements
        $user = User::factory()->create();
        $response = $this->post('/peticionCambiar', ['password' => $user->password, 'userId' => $user->id]);
        $response->assertRedirect('login');

        // Test when password does not meet requirements
        $response = $this->post('/peticionCambiar', ['password' => 'weak', 'userId' => $user->id]);
        $response->assertSessionHasErrors(['error']);

        // Test when user ID is not provided
        $response = $this->post('/peticionCambiar', ['password' => 'NewPassword1!']);
        $response->assertSessionHasErrors(['error']);

        // Test when user does not exist
        $response = $this->post('/peticionCambiar', ['password' => 'NewPassword1!', 'userId' => 9999]);
        $response->assertSessionHasErrors(['error']);
    }
}
