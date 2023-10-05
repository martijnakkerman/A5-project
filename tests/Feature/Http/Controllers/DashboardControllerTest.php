<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsViewWhenAuthenticated()
    {
        // Assuming you have a user authentication system, create a user and authenticate them.
        $user = User::factory()->create();
        $this->actingAs($user);

        // Make a GET request to the 'dashboard' route.
        $response = $this->get(route('dashboard'));

        // Assert that the response is successful (status code 200) and that it's a view.
        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }
}
