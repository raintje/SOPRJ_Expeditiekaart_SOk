<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\RoleAssignRequest;
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
     * Navigates to the relevant page and asserts that it contains the required data.
     * 
     * @return void
     */
    public function testEditUserPageContainsRoles() 
    {
        $user = User::first();
        $ranUser = $this->faker()->randomElement(User::all());
        Auth::login($user);
        $response = $this->get(route('users.edit', $ranUser->id));
        $response->assertViewHas('roles');
    }

    /**
     * Tests the controller function for the updating of a user's role with correct data.
     * 
     * @return void
     */
    public function testEditUserRoleControllerFunction()
    {
        // Controller
        $controller = new UserController();

        // Request for parameter
        $request = RoleAssignRequest::create('/users/', 'POST', [
           'role' => $this->faker()->randomElement(Role::all()),
        ]);

        // Response
        $user = $this->faker()->randomElement(User::all()->pluck('id'));
        $response = $controller->updateRole($request, $user);

        // Assert status
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tests the route for the updating of a user's role with incorrect data.
     * 
     * @return void
     */
    public function testEditUserRoleIncorrectData()
    {
        // Define variables
        $user = User::first();
        $ranUser = $this->faker()->randomElement(User::all()->except('admin'));

        // Login as admin
        Auth::login($user);

        // Create request
        $response = $this->put(route('user.update.role', ['user' => $ranUser->id]), [
            'role' => null,
        ]);

        // Assert session has errors.
        $response->assertSessionHasErrors('role');
    }
    
}
