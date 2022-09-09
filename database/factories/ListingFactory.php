<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(
        [
        'title' => "string",
        'tags' => "string",
        'company' => "string",
        'email' => "string",
        'website' => "string",
        'location' => "string",
        'description' => "string"
        ]
    )] public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'tags' => 'laravel, api, backend',
            'company' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'website' => $this->faker->url(),
            'location' => $this->faker->city(),
            'description' => $this->faker->paragraph(5),
        ];
    }
}
