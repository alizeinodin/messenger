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
}
