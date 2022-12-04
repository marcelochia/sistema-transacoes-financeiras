<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;
    
    public function testRootRouteMustBeRedirectedToLoginRoute()
    {
        $response = $this->get('/');
        $response->assertLocation('/login');
    }

    public function testUserCanBeAuthenticateUsingTheLoginScreen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect('/transacoes');
    }

    public function testUserCanNotBeAuthenticateWithWrongPassword()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $this->assertGuest();
    }

    public function testUserCanNotBeAuthenticateWithWrongEmail()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => 'email@email.com',
            'password' => 'password'
        ]);

        $this->assertGuest();
    }
}
