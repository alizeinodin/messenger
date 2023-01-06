<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    private function createUser()
    {
        return User::factory()->create();
    }

    use RefreshDatabase;

    /**
     * test register user
     *
     * @return void
     */
    public function test_register()
    {
        $req = [
            'name' => 'name',
            'username' => fake()->unique()->userName(),
            'password' => '11111111'
        ];
        $response = $this->postJson(route('register', $req));


        $response->assertStatus(201);
    }

    public function test_login()
    {
        $username = fake()->unique()->userName();
        $req = [
            'name' => 'name',
            'username' => $username,
            'password' => '11111111'
        ];
        $response = $this->postJson(route('register', $req));


        $response->assertStatus(201);

        $req = [
            'username' => $username,
            'password' => '11111111',
        ];

        $response = $this->postJson(route('login', $req));
        $response->assertOk();
    }

    public function test_logout()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        $this->assertAuthenticated();
        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(204);
    }

    public function test_is_user_logged_in_failed_if_user_not_login()
    {
        $response = $this->getJson(route('auth.isLoggedIn'));
        $response->assertStatus(401);
    }
}
