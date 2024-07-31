<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        Author::factory()->create();
        return [
            'code'        => Str::random(5),
            'title'       => fake()->name(),
            'stock'       => 12,
            'm_author_id' => Author::inRandomOrder()->first()->id,
        ];
    }
}
