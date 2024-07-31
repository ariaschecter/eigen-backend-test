<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TBook>
 */
class TBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        Book::factory()->create();
        Member::factory()->create();

        return [
            'borrow_date' => Carbon::now(),
            'm_member_id' => Member::inRandomOrder()->first()->id,
            'm_book_id'   => Book::inRandomOrder()->first()->id,
            'code'        => Str::random(6),
        ];
    }
}
