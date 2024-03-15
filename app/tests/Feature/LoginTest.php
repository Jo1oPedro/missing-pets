<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testSuccessFullLogin()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
           'email' => $user->email,
           'password' => 'password'
        ]);

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('expires_in', $data);
    }

    public function testFailedLogin()
    {
        $response = $this->post('/api/login', [
           'email' => 'emailErrado@gmail.com',
           'password' => 'cascatinha'
        ]);

        $response->assertStatus(401);
    }

    public function tearDown(): void
    {
        DB::table('users')->truncate();
    }
}
