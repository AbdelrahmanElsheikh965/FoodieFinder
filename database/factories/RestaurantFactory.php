<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'name'      => fake()->word(),
            'email'     => fake()->email(),
            'phone'     => fake()->phoneNumber(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', # password//fake()->password(6, 20),
            'region_id' => 1,
            'image' => fake()->word() . '.png',
            'shipping_taxes' => fake()->randomFloat(2)
        ];
    }
}
