<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
		'booked_at' => $this->faker->dateTimeBetween('+1 days','+1 month'),
		'specialist_id'=> Specialist::factory(),
		'service_id'=> Service::factory(),
        ];
    }
}
