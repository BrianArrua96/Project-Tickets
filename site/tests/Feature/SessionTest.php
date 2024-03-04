<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testProfile()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('perfil');
        $response->assertOk();
    }

    public function testLogout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('session');
        $response->assertOk();
    }

    public function testLogin()
    {
        $response = $this->post('/login');

        $response->assertStatus(200); // Assuming login view returns HTTP 200
    }

    public function testSessionController()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('session', ['sesionOpcion' => 'profile']);
        $response->assertOk();

        // Test 'closeSession' session option
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('session', ['sesionOpcion' => 'closeSession']);
        $response->assertRedirect('/login'); // Assuming the redirection after logout is to 'login'

        // Test 'openSession' session option
        $response = $this->actingAs($user)->withSession(['key' => $user->id])->post('session', ['sesionOpcion' => 'openSession']);
        $response->assertRedirect('/login');
    }
}
