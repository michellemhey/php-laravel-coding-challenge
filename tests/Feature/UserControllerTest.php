<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
    * @return void
    */
    public function testIndex(): void
    {
        $response = $this->call('GET', 'users');
        $response->assertStatus(200);
    }

    /**
    * @return void
    */
    public function testShow(): void
    {
        $user = factory(User::class)->create();

        $response = $this->call('GET', "/users/{$user->id}");

        $response->assertStatus(200);
    }

    /**
    * @return void
    */
    public function testCreate(): void
    {
        $response = $this->call('GET', 'users/create');

        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $response = $this->followingRedirects()
            ->call('POST', '/users', ['first_name' => 'Mary', 'last_name' => $last_name = $this->faker()->name, 'gender' => 'female', 'country' => 'US', 'email' => $email = $this->faker()->unique()->safeEmail])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => $email]);

        $user = User::whereEmail($email)->first();
    }

    public function testEdit(): void
    {
        $user = factory(User::class)->create();

        $response = $this->call('GET', "/users/{$user->id}");

        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $user = factory(User::class)->create();
        
        $response = $this->followingRedirects()
            ->call('PUT', "/users/{$user->id}", ['gender' => 'male'])
            ->assertStatus(200);

        $this->assertDatabaseHas('users', ['gender' => 'male']);
    }
}
