<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use App\Models\TBook;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TBookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_borrow_record()
    {
        // Create a book and a member for the test
        $book = Book::factory()->create();
        $member = Member::factory()->create();

        // Make a POST request to create a new borrow record
        $response = $this->postJson('/api/v1/borrows', [
            'm_member_id' => $member->id,
            'm_book_id'   => $book->id,
        ]);

        // Assert the response status
        $response->assertStatus(201)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'id',
                    'code',
                    'm_member_id',
                    'm_book_id',
                    'borrow_date',
                    'created_at',
                    'updated_at'
                ],
                'dev'
            ]);

        // Assert that the borrow record was created in the database
        $this->assertDatabaseHas('t_books', [
            'm_member_id' => $member->id,
            'm_book_id'   => $book->id
        ]);
    }

    public function test_can_not_create_a_borrow_record_while_got_penalty()
    {
        // Create a book and a member for the test
        $book = Book::factory()->create();
        $member = Member::factory()->create([
            'penalty' => Carbon::now(),
        ]);

        // Make a POST request to create a new borrow record
        $response = $this->postJson('/api/v1/borrows', [
            'm_member_id' => $member->id,
            'm_book_id'   => $book->id,
        ]);

        // Assert the response status
        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'message'     => __('tBook.failed.member_penalty'),
                'errors'      => [],
                'dev'         => null,
            ]);
    }

    public function test_can_not_create_a_borrow_record_while_book_empty()
    {
        // Create a book and a member for the test
        $book = Book::factory()->create([
            'stock' => 0
        ]);
        $member = Member::factory()->create();

        // Make a POST request to create a new borrow record
        $response = $this->postJson('/api/v1/borrows', [
            'm_member_id' => $member->id,
            'm_book_id'   => $book->id,
        ]);

        // Assert the response status
        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'message'     => __('tBook.failed.book_quota'),
                'errors'      => [],
                'dev'         => null,
            ]);
    }

    public function test_can_not_create_a_borrow_record_while_member_quota()
    {
        // Create a book and a member for the test
        $member = Member::factory()->create();

        TBook::factory(2)->create([
            'm_member_id' => $member->id
        ]);

        $book = Book::factory()->create([
            'stock' => 13
        ]);

        $response = $this->postJson('/api/v1/borrows', [
            'm_member_id' => $member->id,
            'm_book_id'   => $book->id,
        ]);
        // Assert the response status
        $response->assertStatus(422)
            ->assertJson([
                'status_code' => 422,
                'message'     => __('tBook.failed.member_quota'),
                'errors'      => [],
                'dev'         => null,
            ]);
    }

    public function test_can_get_all_borrows_record()
    {
        // Create a book, a member, and a borrow record
        TBook::factory()->create();

        // Make a GET request to retrieve the borrow record
        $response = $this->getJson("/api/v1/borrows");

        // dd($response->json());
        // Assert the response status
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data',
                'dev'
            ]);
    }
}
