<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;
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
        $user = User::find(31);
        Auth::login($user);
        $response = $this->get(route('users.create'));
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
        $response = $this->post(route('users.create', ['name' => $this->faker->name], ['email' => $this->faker->unique()->email]));
        $response->assertSessionHasNoErrors();
    }

    /**
     * Tries to insert a new user with invalid data and asserts if the error is successfully caught.
     * @dataProvider additionalInvalidInformation
     * @return void
     */
    public function testCreateInvalidInformation($name, $email, $nameAssert, $emailAssert)
    {
        $user = new User(array('name' => 'fake'));

        $response = $this->be($user)->post('/users', [
            'name' => $name,
            'email' => $email,
        ]);

        if($nameAssert){
            $response->assertSessionDoesntHaveErrors('name');
        } else {
            $response->assertSessionHasErrors('name');
        }

        if($emailAssert){
            $response->assertSessionDoesntHaveErrors('email');
        } else {
            $response->assertSessionHasErrors('email');
        }

        //remove
        if($emailAssert && $nameAssert){
            $response->assertSessionHasNoErrors();
            User::where('email', $email)->delete();
        }
    }

    public function additionalInvalidInformation(): array
    {
        return [
            ['', '', false, false],
            [null, null, false, false],
            ['works', 'works@gmail.com', true, true],
            ['test', 'test', true, false]
        ];
    }

}
