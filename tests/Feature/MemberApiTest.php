<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_create_member()
    {
        $response = $this->postJson('/api/v1/members', [
            'name' => 'Test Member',
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

        $this->assertDatabaseHas('m_members', [
            'name' => 'Test Member'
        ]);
    }

    public function test_can_get_member()
    {
        $author = Member::factory()->create([
            'name' => 'Test Member',
        ]);

        $response = $this->getJson("/api/v1/members/{$author->id}");

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



    public function test_can_update_member()
    {
        $author = Member::factory()->create([
            'name' => 'Old Member',
        ]);

        $response = $this->putJson("/api/v1/members/{$author->id}", [
            'name' => 'Updated Member',
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

        $this->assertDatabaseHas('m_members', [
            'id'   => $author->id,
            'name' => 'Updated Member',
        ]);
    }

    public function test_can_delete_member()
    {
        $author = Member::factory()->create([
            'name' => 'Test Member',
        ]);

        $response = $this->deleteJson("/api/v1/members/{$author->id}");

        $response->assertStatus(200);
    }

    public function test_cannot_create_member_with_missing_name()
    {
        // Missing 'name' field
        $response = $this->postJson('/api/v1/members', []);

        $response->assertStatus(422)  // Expecting validation error status
            ->assertJsonStructure([
                'status_code',
                'message',
                'errors'
            ]);
    }

    public function test_cannot_get_non_existent_member()
    {
        // Try to retrieve a member that does not exist
        $response = $this->getJson('/api/v1/members/99999999');

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_update_non_existent_member()
    {
        // Try to update a member that does not exist
        $response = $this->putJson('/api/v1/members/99999999', [
            'name' => 'Updated Member'
        ]);

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }

    public function test_cannot_delete_non_existent_member()
    {
        // Try to delete a member that does not exist
        $response = $this->deleteJson('/api/v1/members/99999999');

        $response->assertStatus(404)  // Expecting not found status
            ->assertJsonStructure([
                'status_code',
                'message'
            ]);
    }
}
