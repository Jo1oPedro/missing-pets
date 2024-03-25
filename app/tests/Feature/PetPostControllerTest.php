<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetPostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function get_pet_posts_paginated_sucessfully(): void
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
}
