<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditUserRoleTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Navigates to the relevant page and asserts that the response matches the expected value.
     *
     * @return void
     */
    public function testEditUserPageResponse()
    {
        $user = User::first();
        $ranUser = $this->faker()->randomElement(User::all());
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('users.edit', $ranUser->id));
        $response->assertViewIs('users.edit');
        $response->assertStatus(200);
    }

    /**
     * Navigates to the relevant page with the wrong ID and asserts that the response matches the expected value.
     * 
     * @return void
     */
    public function testEditUserPageResponseWrongID() 
    {
        $user = User::first();
        Auth::login($user);
        $response = $this->get(route('users.edit', User::all()->last()->id + 1 ));
        $response->assertStatus(404);
    }

    /**
     * Navigates to the relevant page and asserts that it contains the correct data.
     */
    public function testEditUserPageContainsCorrectRoles() 
    {
        $user = User::first();
        $ranUser = $this->faker()->randomElement(User::all());
        $roles = Role::all()->except('super admin')->toArray();
        Auth::login($user);
        $response = $this->get(route('users.edit', $ranUser->id));
        $response->assertViewHasAll($roles);
    }
}
