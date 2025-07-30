<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "perfil_img" => $this->faker->imageUrl(),
            "capa_img" =>  $this->faker->imageUrl(),
            "open_time" => $this->faker->time(),
            "close_time"=> $this->faker->time(),
            "phone" => $this->faker->phoneNumber(),
            "email" => $this->faker->email(),
            'address_id' => Address::factory()
        ];
    }
}
