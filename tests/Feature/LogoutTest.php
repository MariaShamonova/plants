<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\User;
Use App\Models\Plants;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/plants', [], $headers)->assertStatus(200);
        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $user->api_token = null;
        $user->save();

        $this->json('get', '/api/plants', [], $headers)->assertStatus(401);
    }
}
