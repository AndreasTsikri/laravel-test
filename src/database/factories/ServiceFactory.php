<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
	    $ns = ['hairstyle','maniqure','pedicure'];
        return [
		'name' => $this->faker->randomElement($ns),
	       'duration' => $this->faker->randomElement([20,30,40,60])
        ];
    }
}
