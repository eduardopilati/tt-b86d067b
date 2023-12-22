<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testCanAccessUserScreen(): void
    {
        $response = $this->logged()->get('/users');

        $response->assertStatus(200);
    }

    public function testCanAccessUserScreenWithUsers(): void
    {
        User::factory()->count(5)->create();

        $response = $this->logged()->get('/users');

        $response->assertStatus(200);

        $response->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Users/ListUsers')
            ->has('users.data', 6));
    }

    public function testCanAccessCreateUserScreen(): void
    {
        $response = $this->logged()->get('/users/create');

        $response->assertStatus(200);
    }

    public function testCanCreateUser(): void
    {
        $newUser = User::factory()->make();

        $response = $this->logged()->post('/users', [
            'name' => $newUser->name,
            'document' => $newUser->document,
            'password' => UserFactory::PASSWORD,
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'name' => $newUser->name,
            'document' => $newUser->document,
        ]);
    }

    public function testCanCreateUserWithPassword(): void
    {
        $newUser = User::factory()->make();

        $response = $this->logged()->post('/users', [
            'name' => $newUser->name,
            'document' => $newUser->document,
            'password' => 'Test123456',
        ]);

        $response->assertRedirect('/users');

        $user = User::where('document', $newUser->document)->first();
        Hash::check('Test123456', $user->password);
    }

    public function testCantCreateUserWithWeakPassword(): void
    {
        $newUser = User::factory()->make();

        $response = $this->logged()->post('/users', [
            'name' => $newUser->name,
            'document' => $newUser->document,
            'password' => '123456',
        ]);

        $response->assertInvalid(['password']);
    }

    public function testCantCreateUserDuplicatedDocument(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->post('/users', [
            'name' => $user->name,
            'document' => $user->document,
            'password' => UserFactory::PASSWORD,
        ]);

        $response->assertInvalid(['document']);
    }

    public function testCantCreateUserMissingFields(): void
    {
        $response = $this->logged()->post('/users', []);

        $response->assertInvalid([
            'name',
            'document',
        ]);
    }

    public function testCanAccessEditUserScreen(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->get("/users/{$user->id}/edit");

        $response->assertStatus(200);
    }

    public function testCanUpdateUser(): void
    {
        $user = User::factory()->create();
        $newUser = User::factory()->make();

        $response = $this->logged()->put("/users/$user->id", [
            'name' => $newUser->name,
            'document' => $newUser->document,
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newUser->name,
            'document' => $newUser->document,
        ]);
    }

    public function testCanUpdateUserPassword(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->put("/users/$user->id", [
            'name' => $user->name,
            'document' => $user->document,
            'password' => 'New123456',
        ]);

        $response->assertRedirect('/users');

        $user = User::find($user->id);
        Hash::check('New123456', $user->password);
    }

    public function testCantUpdateWeakPassword(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->put("/users/$user->id", [
            'name' => $user->name,
            'document' => $user->document,
            'password' => '123456',
        ]);

        $response->assertInvalid(['password']);
    }

    public function testCantUpdateUserDuplicatedDocument(): void
    {
        $user = User::factory()->create();
        $newUser = User::factory()->create();

        $response = $this->logged()->put("/users/$user->id", [
            'name' => $user->name,
            'document' => $newUser->document,
        ]);

        $response->assertInvalid(['document']);
    }

    public function testCantUpdateUserMissingFields(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->put("/users/$user->id", []);

        $response->assertInvalid([
            'name',
            'document',
        ]);
    }

    public function testCanDeleteUser(): void
    {
        $user = User::factory()->create();

        $response = $this->logged()->delete("/users/$user->id");

        $response->assertRedirect('/users');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function testCanSearchUser(): void
    {
        User::factory()->count(3)->create([
            'name' => 'Orange',
        ]);

        User::factory()->count(3)->create([
            'name' => 'Pumpkin',
        ]);

        $response = $this->logged()->get('/users/search?searchTerm=Orange');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $page) => $page
            ->count(3));
    }

    public function testCanSearchAllUsers(): void
    {
        User::factory()->count(3)->create([
            'name' => 'Orange',
        ]);

        User::factory()->count(3)->create([
            'name' => 'Pumpkin',
        ]);

        $response = $this->logged()->get('/users/search?searchTerm=');

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $page) => $page
            ->count(7));
    }
}
