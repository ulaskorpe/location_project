<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    
        return [
            'user_id'=>User::all()->random()->id,
            'name'=>$this->faker->sentence(),
            'color'=> $this->faker->randomElement(['red','blue','green']),
            'latitude'=>mt_rand(-90000000, 90000000) / 1000000,
            'longitude'=>mt_rand(-180000000, 180000000) / 1000000
        ];
    }
}
