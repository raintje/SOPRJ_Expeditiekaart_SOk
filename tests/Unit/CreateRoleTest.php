<?php

namespace Tests\Unit;

use App\Http\Controllers\RoleController;
use App\Http\Requests\RoleStoreRequest;
use App\Models\LayerItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;

class CreateRoleTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Navigates to the web page and asserts if the response matches the expected output.
     *
     * @return void
     */
    public function testCreateRolePageResponse()
    {
        $user = User::first();
        Auth::login($user);
        $response = $this->get(route('roles.create'));
        $response->assertViewIs('roles.create');
        $response->assertStatus(200);
    }

    /**
     * Asserts if the correct response is returned when a role is stored.
     *
     * @return void
     */
    public function testRoleStore()
    {
        // Controller
        $controller = new RoleController();

        // Request for parameter
        $name = $this->faker()->word();
        $request = RoleStoreRequest::create('/roles/', 'POST', [
            'name' => $name,
            'itemLinks' => $this->faker()->randomElements(LayerItem::all()->pluck('id')),
        ]);

        // Response
        $response = $controller->store($request);

        // Assert status
        $this->assertEquals(302, $response->getStatusCode());
        Role::where('name', $name)->delete();
    }

    /**
     * Tries to insert a new role with valid information into the database and asserts if all goes as planned.
     *
     * @dataprovider ValidInformation
     * @return void
     */
    public function testCreateValidInformation()
    {
        $name = $this->faker->word;
        $response = $this->post(route('roles.create', ['name' => $name], ['itemLinks' => $this->faker->unique()->randomElements(LayerItem::all()->pluck('id'))]));
        $response->assertSessionHasNoErrors();
        Role::where('name', $name)->delete();
    }

    /**
     * Tries to insert a new role with invalid information into the database and asserts if it's rejected.
     *
     * @return void
     */
    public function testCreateInvalidInformation()
    {
        $name = $this->faker->word;
        $response = $this->post(route('roles.create', ['name' => $name], ['itemLinks' => null]));
        $response->assertSessionHasNoErrors();
        Role::where('name', $name)->delete();
    }

}
