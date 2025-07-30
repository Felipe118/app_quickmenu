<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "address_name" => $this->faker->address,
            "neighborhood" => $this->faker->city,
            "quatrain" => $this->faker->streetAddress,
            "number" => $this->faker->buildingNumber,
            "complement" =>  $this->faker->secondaryAddress,
            "district" => $this->faker->postcode,
            "city" => $this->faker->city,
            "state" => $this->faker->name,
            "cep" => $this->faker->postcode,
        ];
    }
}
