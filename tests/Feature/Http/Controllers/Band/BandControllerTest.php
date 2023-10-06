<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Band;
use App\Models\User;
use App\Models\Embed;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BandControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreBand()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $users = User::factory(3)->create();
        $users[] = $user;

        // Create a temporary file for testing
        $uploadedFile = UploadedFile::fake()->create('test_image.jpg', 200);

        // Store the file in the storage disk you want to use (e.g., 'public')
        $filePath = $uploadedFile->store('images', 'public');
        $faker = Faker\Factory::create();
        $data = [
            'name' => 'Test Band',
            'text_color' => $faker->hexColor,
            'background_color' => $faker->hexColor,
            'description' => 'Test Description',
            'biography' => 'Test Biography',
            'image' => $uploadedFile, // Pass the UploadedFile instance directly
            'users' => $users->pluck('id')->toArray(),
            'embed_url' => ['https://example.com/embed1', 'https://example.com/embed2'],
        ];


        $response = $this->actingAs($user)->post(route('band.store'), $data);

        $response->assertStatus(302); // Check if the redirect is successful
        $response->assertSessionHas('success', 'Band: Test Band was successfully created.');

        // Assert that the band was created in the database
        $this->assertDatabaseHas('band', ['name' => 'Test Band']);

        // Assert that the image was stored in the public disk
        Storage::disk('public')->assertExists($filePath);

        // Assert that users are attached to the band
        $band = Band::where('name', 'Test Band')->first();
        $this->assertEquals($users->count(), $band->users->count());
        foreach ($users as $user) {
            $this->assertTrue($band->users->contains($user));
        }

        // Assert that embeds were created for the band
        $this->assertCount(2, $band->embeds);
        return ['band' => $band, 'user'=> $user, 'users' => $users];
    }

    public function testUpdateBand()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $band = Band::factory()->create();
        $user->bands()->attach($band);
        $users = User::factory(3)->create();
        $users[] = $user;

        // Create a temporary file for testing
        $uploadedFile = UploadedFile::fake()->create('test_image.jpg', 200);

        // Store the file in the storage disk you want to use (e.g., 'public')
        $filePath = $uploadedFile->store('images', 'public');
        $faker = Faker\Factory::create();
        $data = [
            'name' => 'Updated Band Name',
            'text_color' => $faker->hexColor,
            'background_color' => $faker->hexColor,
            'description' => 'Updated Description',
            'biography' => 'Updated Biography',
            'image' => $uploadedFile, // Pass the UploadedFile instance directly
            'users' => $users->pluck('id')->toArray(),
            'embed_url' => ['https://example.com/embed1', 'https://example.com/embed2'],
        ];

        $response = $this->actingAs($user)->patch(route('band.update', $band->id), $data);

        $response->assertStatus(302); // Check if the redirect is successful
        $response->assertSessionHas('success', 'Band information updated.');

        // Assert that the band information was updated in the database
        $this->assertDatabaseHas('band', [
            'id' => $band->id,
            'name' => 'Updated Band Name',
            'description' => 'Updated Description',
        ]);

        // Assert that the new image was stored and the old one was deleted
        Storage::disk('public')->assertMissing($band->image_path);
        Storage::disk('public')->assertExists($filePath);

        // Assert that embeds were updated for the band
        $band = $band->fresh(); // Refresh the band instance to get the updated relationship
        $this->assertCount(2, $band->embeds);
    }

    public function testDestroyBand()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $band = Band::factory()->create();
        $user->bands()->attach($band);

        $response = $this->actingAs($user)->delete(route('band.destroy',$band->id));

        $response->assertStatus(302); // Check if the redirect is successful
        $response->assertSessionHas('success', 'Your band: ' . $band->name . ' has been deleted.');

        // Assert that the band was deleted from the database
        $this->assertDatabaseMissing('band', ['id' => $band->id]);

        // Assert that the image was deleted
        Storage::disk('public')->assertMissing($band->image_path);

        // Assert that users are detached from the band
        $this->assertEquals(0, $band->users->count());

        // Assert that embeds were deleted for the band
        $this->assertCount(0, Embed::where('band_id', $band->id)->get());
    }
}
