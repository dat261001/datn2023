<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\banner>
 */
class bannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker,
            'img' => "273959030_1580032779026777_1068352733615228680_n.jpg",
            'position' => "Banner Center",
            'url' => 'test',
        ];
    }
}
