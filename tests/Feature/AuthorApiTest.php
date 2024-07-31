<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_create_author()
    {
        $response = $this->postJson('/api/v1/authors', [
            'name' => 'Test Author',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'id',
                    'code',
                    'name',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);

        $this->assertDatabaseHas('m_authors', [
            'name' => 'Test Author'
        ]);
    }

    public function test_can_get_author()
    {
        $author = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $response = $this->getJson("/api/v1/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'id',
                    'code',
                    'name',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);
    }



    public function test_can_update_author()
    {
        $author = Author::factory()->create([
            'name' => 'Old Author',
        ]);

        $response = $this->putJson("/api/v1/authors/{$author->id}", [
            'name' => 'Updated Author',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status_code',
                'message',
                'data' => [
                    'id',
                    'code',
                    'name',
                    'created_at',
                    'updated_at',
                ],
                'dev'
            ]);

        $this->assertDatabaseHas('m_authors', [
            'id'   => $author->id,
            'name' => 'Updated Author',
        ]);
    }

    public function test_can_delete_author()
    {
        $author = Author::factory()->create([
            'name' => 'Test Author',
        ]);

        $response = $this->deleteJson("/api/v1/authors/{$author->id}");

        $response->assertStatus(200);
    }

    public function test_cannot_create_author_with_missing_name()
    {
        // Missing 'name' field
        $response = $this->postJson('/api/v1/authors', []);

        $response->assertStatus(422)  // Expecting validation error status
            ->assertJsonStructure([
                'status_code',
                'message',
                'errors'
            ]);
    }

    public function test_cannot_get_non_existent_author()
    {
        // Try to retrieve an author that does not exist
        $response = $this->getJson('/api/v1/authors/99999999');

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_update_non_existent_author()
    {
        // Try to update an author that does not exist
        $response = $this->putJson('/api/v1/authors/99999999', [
            'name' => 'Updated Author'
        ]);

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_delete_non_existent_author()
    {
        // Try to delete an author that does not exist
        $response = $this->deleteJson('/api/v1/authors/99999999');

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

}
