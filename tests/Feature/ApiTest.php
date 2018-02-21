<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchListOfUsers()
    {
        /** @var Collection $users */
        $users = factory(User::class, 10)->create();

        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'users' => $users->toArray()
        ]);
    }

    public function testCreateAUser()
    {
        $user = factory(User::class)->make();

        $response = $this->post('/users', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'state' => $user->state
        ]);

        $response->assertJson(['status' => true]);

        $this->assertDatabaseHas('users', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'state' => $user->state
        ]);
    }

    public function testFetchOfAUser()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $response = $this->get('/users/' . $user->id);

        $response->assertJson([
            'user' => $user->toArray(),
            'status' => true
        ]);
    }

    public function testModifyUsersInfo()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $user->save([
            'first_name' => 'Test FN',
            'last_name' => 'Test LN',
            'email' => 'test@test.com',
        ]);

        $response = $this->put('/users/' . $user->id, [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'state' => $user->state
        ]);
        $response->assertJson([
            'status' => true
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'state' => $user->state
        ]);
    }
}
