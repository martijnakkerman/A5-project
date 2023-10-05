<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Band;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Band>
 */
class BandFactory extends Factory
{
    protected $model = Band::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'biography' => $this->faker->text,
            'image_path' => $this->faker->imageUrl,
            'text_color' => $this->faker->hexColor,
            'background_color' => $this->faker->hexColor,
        ];
    }
}
