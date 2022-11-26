<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * test register user
     *
     * @return void
     */
    public function test_register()
    {
        $req = [
            'name' => 'name',
            'username' => 'alizne',
            'password' => '11111111'
        ];
        $response = $this->postJson(route('register', $req));


        $response->assertStatus(201);
    }
}
