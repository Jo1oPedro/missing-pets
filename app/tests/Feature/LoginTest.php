<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
    }

    public function testSuccessFullLogin()
    {
        $this->post('/api/register', [
            'name' => 'cascata',
            'email' => 'cascata@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $response = $this->post('/api/login', [
           'email' => 'cascata@gmail.com',
           'password' => '12345678'
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
        DB::table('users')->delete();
    }
}
