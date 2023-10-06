<?php

namespace Tests\Feature\Controllers\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserEditViewIsAccessible()
    {
        // Create a user
        $user = User::factory()->create();

        // Act: Visit the user edit page while authenticated
        $response = $this->actingAs($user)->get(route('user.edit'));

        // Assert: Check if the user edit view is accessible
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
    }

    public function testUserUpdate()
    {
        // Create a user
        $user = User::factory()->create();

        // Act: Attempt to update the user's information
        $response = $this->actingAs($user)->patch(route('user.update', $user->id), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        // Assert: Check if the update is successful
        $response->assertStatus(302); // Check if the redirect is successful
        $response->assertSessionHas('success', 'User information updated');

        // Assert: Check if the user's information was updated in the database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }
}

