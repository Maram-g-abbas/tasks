<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

         /** @test */
         public function it_can_register_a_user()
         {
            $response = $this->postJson('/api/register', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);
    
            $response->assertStatus(201)
                     ->assertJsonStructure([
                         'user' => ['id', 'name', 'email'],
                         'token'
                     ]);
    
            $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        }
}
