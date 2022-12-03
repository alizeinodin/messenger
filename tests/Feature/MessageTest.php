<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    private function createUser()
    {
        return User::factory()->create();
    }

    public function test_send_message()
    {
        $sender = $this->createUser();
        Sanctum::actingAs($sender);

        $receiver = $this->createUser();
        $message = 'TEXT MESSAGE';

        $request = [
            'content' => $message,
            'receiver_id' => $receiver->id
        ];

        $response = $this->postJson(route('sendMessage', $request));
        $response->assertCreated();
    }
}
