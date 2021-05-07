<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateUserTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Tests if the view is correctly displayed.
     *
     * @return void
     */
    public function testCreateUserPageResponse()
    {
        $response = $this->get(route('create.user'));
        $response->assertViewIs('users.create');
        $response->assertStatus(200);
    }

    /**
     * Asserts if the correct response is returned when a user is stored.
     *
     * @return void
     */
    public function testUserStore()
    {
        // Controller
        $controller = new UserController();

        // Request for parameter
        $request = UserStoreRequest::create('/users/', 'POST', [
           'name' => $this->faker->name,
           'email' => $this->faker->unique()->email,
        ]);

        // Response
        $response = $controller->store($request);

        // Assert status
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Tries to insert a new user with valid information into the database and asserts if all goes as planned.
     *
     * @return void
     */
    public function testCreateValidInformation()
    {
        $response = $this->post(route('create.user', ['name' => $this->faker->name], ['email' => $this->faker->unique()->email]));
        $response->assertSessionHasNoErrors();
    }

    /**
     * Tries to insert a new user with invalid data and asserts if the error is successfully caught.
     *
     * @return void
     */
    public function testCreateInvalidInformation()
    {
        $response = $this->post(route('create.user', ['name' => null], ['email' => null]));
        $response->assertStatus(405);
    }

}
