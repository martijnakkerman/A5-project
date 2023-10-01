<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Band;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsView()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('home');
    }

    public function testIndexWithSearch()
    {
        // Create a band in the database for testing
        Band::factory()->create([
            'name' => 'Test Band',
            'description' => 'This is a test band',
        ]);

        $response = $this->get('/?search=Test');

        $response->assertStatus(200)
            ->assertViewIs('home')
            ->assertSee('Test Band'); // Make sure the band with the search term is visible in the response
    }

    public function testIndexWithNoSearch()
    {
        // Create some test bands in the database
        Band::factory(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('home')
            ->assertSee('List of Bands'); // Assuming this text appears in your view
    }
}

