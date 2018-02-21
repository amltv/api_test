<?php

namespace Tests\Feature;

use App\Models\Group;
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

        $request_data = [
            'first_name' => 'Test FN',
            'last_name' => 'Test LN',
            'email' => 'test@test.com',
            'state' => !$user->state//change state
        ];

        $response = $this->put('/users/' . $user->id, $request_data);
        $response->assertJson([
            'status' => true
        ]);

        $this->assertDatabaseHas('users', array_merge(['id' => $user->id], $request_data));
    }

    public function testFetchListOfGroups() {
        /** @var Collection $groups */
        $groups = factory(Group::class, 10)->create();

        $response = $this->get('/groups');
        $response->assertJson([
            'status' => true,
            'groups' => $groups->toArray()
        ]);
    }

    public function testCreateAGroup()
    {
        /** @var Group $group */
        $group = factory(Group::class)->make();

        $response = $this->post('/groups', [
            'name' => $group->name
        ]);
        $response->assertJson(['status' => true]);

        $this->assertDatabaseHas('groups', [
            'name' => $group->name
        ]);
    }

    public function testModifyGroupInfo()
    {
        /** @var Group $group */
        $group = factory(Group::class)->create();

        $request_data = [
            'name' => 'Test Group'
        ];

        $response = $this->put('/groups/' . $group->id, $request_data);
        $response->assertJson(['status' => true]);

        $this->assertDatabaseHas('groups', array_merge(['id' => $group->id], $request_data));
    }
}
