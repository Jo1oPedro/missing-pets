<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetPostControllerTest extends TestCase
{
    private $url = "/api/pet/posts";
    /**
     * A basic feature test example.
     */
    public function test_can_get_pet_posts_paginated_sucessfully(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/pet/posts');
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    "current_page",
                    "data",
                    "first_page_url",
                    "from",
                    "last_page",
                    "last_page_url",
                    "links" => [
                        "*" => [
                            "url",
                            "label",
                            "active",
                        ],
                    ],
                    "next_page_url",
                    "path",
                    "per_page",
                    "prev_page_url",
                    "to",
                    "total",
                ]
            );
    }

    public function test_can_create_pet_post_sucessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(
            '/api/pet/posts',
            [
                'user_id' => $user->id,
                'coordinate_x' => random_int(1, 10000),
                'coordinate_y' => random_int(1, 10000),
                'breed' => fake()->name,
                'type' => fake()->name,
                'additional_info' => fake()->text(100)
            ]
        );

        $response->assertStatus(201);
        $response->assertJsonStructure([
            "data" => [
                "user_id",
                "coordinate_x",
                "coordinate_y",
                "breed",
                "type",
                "additional_info",
                "updated_at",
                "created_at",
                "id"
            ]
        ]);
    }
}
