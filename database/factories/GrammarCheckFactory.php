<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrammarCheck>
 */
class GrammarCheckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'school' => fake()->company() . ' University',
            'original_text' => fake()->paragraphs(3, true),
            'corrected_text' => fake()->paragraphs(3, true),
            'suggestions' => fake()->sentence(20),
        ];
    }
}