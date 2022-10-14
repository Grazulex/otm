<?php

namespace Database\Factories;

use App\Enums\OriginEnums;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plate>
 */
class PlateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reference' => $this->faker->randomDigit().Str::random(6),
            'type' => $this->faker->randomElement(['N1FR', 'TEC']),
            'order_id' => $this->faker->randomNumber(5),
            'customer' => $this->faker->name(),
            'customer_key' => Str::random(25),
            'amount' => $this->faker->randomNumber(2),
            'origin' => $this->faker->randomElement(OriginEnums::cases()),
            'is_cod' => $this->faker->boolean(),
            'is_rush' => $this->faker->boolean(),
            'production_id' => $this->faker->numberBetween(1, 40),
            'datas' => ['destination_street' => 'baba', 'destination_house_number' => 'baba', 'destination_bus' => 'baba', 'destination_city' => 'baba', 'destination_postal_code' => 'baba'],
        ];
    }
}
