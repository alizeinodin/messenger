<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
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
}
