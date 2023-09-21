<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'  => fake()->name(),
            'email' => 'testEmail@mail.com', //fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('###########'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'device_token' => 'eyHOUmQgSOqtdbDYxch7ug:APA91bHkOyO2lnZwhQtQLMv-kIq1JEO1JGa84dGCS5e-BeF6yJCcyXgDMudPbpoxj6nj7gTqRtrjJcLy3pYW77udYQWyZh0tpxP953eWOXZ81YGW0q4_bAdhEaci49s4SddW1AptCAJe',
            'region_id' => 2
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
