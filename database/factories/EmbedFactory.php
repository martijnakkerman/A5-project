<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Embed;
use App\Models\Band;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Embed>
 */
class EmbedFactory extends Factory
{
    protected $model = Embed::class;
    public function definition(): array
    {
        $band = Band::factory()->create();
        return [
            'embed_url' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/Jrg9KxGNeJY?si=fWCymTeYVu1IRCap" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
            'band_id' => $band->id,
        ];
    }
}
