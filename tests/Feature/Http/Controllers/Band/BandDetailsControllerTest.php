<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Band;

class BandDetailsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsViewWithBandData()
    {

        $band = Band::factory()->create();

        // Make a GET request to the 'band.details.index' route, passing the band's ID.
        $response = $this->get(route('band.details', ['band' => $band->id]));

        // Assert that the response is successful (status code 200) and that it's a view.
        $response->assertStatus(200);
        $response->assertViewIs('band.band-details');

        // Assert that the 'band' variable was passed to the view.
        $response->assertViewHas('band', $band);
    }
}

