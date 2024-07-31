<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_book()
    {
        $author = Author::factory()->create();
        $response = $this->postJson('/api/v1/books', [
            'code'        => 'BK-001',
            'title'       => 'Test Book',
            'm_author_id' => $author->id,
            'stock'       => 12
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'code',
                    'title',
                    'm_author_id',
                    'stock',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);

        $this->assertDatabaseHas('m_books', [
            'code'  => 'BK-001',
            'title' => 'Test Book'
        ]);
    }

    public function test_can_get_book()
    {
        // Create a book to retrieve
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'code'        => 'BK-002',
            'title'       => 'Another Test Book',
            'm_author_id' => $author->id,
            'stock'       => 10
        ]);

        $response = $this->getJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'code',
                    'title',
                    'm_author_id',
                    'stock',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);
    }



    public function test_can_update_book()
    {
        // Create a book to update
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'code'        => 'BK-003',
            'title'       => 'Old Title',
            'm_author_id' => $author->id,
            'stock'       => 5
        ]);

        $response = $this->putJson("/api/v1/books/{$book->id}", [
            'code'        => 'BK-003-updated',
            'title'       => 'Updated Title',
            'm_author_id' => $author->id,
            'stock'       => 20
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'code',
                    'title',
                    'm_author_id',
                    'stock',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);

        $this->assertDatabaseHas('m_books', [
            'id'    => $book->id,
            'code'  => 'BK-003-updated',
            'title' => 'Updated Title',
            'stock' => 20
        ]);
    }

    public function test_can_delete_book()
    {
        // Create a book to delete
        $author = Author::factory()->create();
        $book = Book::factory()->create([
            'code'        => 'BK-004',
            'title'       => 'Book to Delete',
            'm_author_id' => $author->id,
            'stock'       => 8
        ]);

        $response = $this->deleteJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200);
    }

    public function test_cannot_create_book_with_missing_fields()
    {
        // Missing 'code' field
        $response = $this->postJson('/api/v1/books', [
            'title'       => 'Invalid Book',
            'm_author_id' => null,
            'stock'       => 12
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'status_code',
                'message',
                'errors',
                'dev'
            ]);
    }

    public function test_cannot_get_non_existent_book()
    {
        $response = $this->getJson('/api/v1/books/99999999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_update_non_existent_book()
    {
        $response = $this->putJson('/api/v1/books/99999999', [
            'code'        => 'BK-005-updated',
            'title'       => 'Updated Title',
            'm_author_id' => null,
            'stock'       => 25
        ]);

        $response->assertStatus(404)
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_delete_non_existent_book()
    {
        $response = $this->deleteJson('/api/v1/books/99999999');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }


}
