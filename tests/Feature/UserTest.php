<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::factory()->create();
    }

    /**
     * get user of request in app
     * @return void
     */
    public function test_get_user(): void
    {
        $user = $this->createUser();
        $this->actingAs($user);

        $response = $this->getJson(route('user.get'));
        $response->assertOk();
    }

    public function test_search_user()
    {
        User::factory()->count(100)->create(); // make 100 user

        $user = $this->createUser();
        $this->actingAs($user); // acting as a user in program

        $request = [
            'username' => 'ali',
        ];

        $response = $this->postJson(route('user.search', $request));
        $response->assertOk();
    }
}
