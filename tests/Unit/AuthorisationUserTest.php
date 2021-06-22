<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorisationUserTest extends TestCase
{
    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    public function test_edit_user_as_admin(){
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $ranUser = $this->faker()->randomElement(User::all());
        Auth::login($admin);
        $this->assertAuthenticated();
        $response = $this->get(route('users.edit', $ranUser->id));
        $response->assertViewIs('users.edit');
        $response->assertStatus(200);
    }

    public function test_edit_user_as_user(){
        $admin = User::factory()->create();
        $ranUser = $this->faker()->randomElement(User::all());
        Auth::login($admin);
        $this->assertAuthenticated();
        $response = $this->get(route('users.edit', $ranUser->id));
        $response->assertStatus(403);
    }

    public function test_edit_item_with_role(){
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $permission = Permission::create(['name' => 'layerItem.edit.1']);
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('edit.item', 1));
        $user->delete();
        $role->delete();
        $permission->delete();
        $response->assertStatus(200);
    }

    public function test_edit_item_without_role()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('edit.item', 1));
        $response->assertStatus(403);

        $user->delete();
    }

    public function test_edit_item_with_wrong_role(){
        $user = User::factory()->create();
        $role = Role::create(['name' => 'test']);
        $permission = Permission::create(['name' => 'layerItem.edit.100']);
        $role->givePermissionTo($permission);

        $user->assignRole($role);

        Auth::login($user);
        $this->assertAuthenticated();
        $response = $this->get(route('edit.item', 1));
        $user->delete();
        $role->delete();
        $permission->delete();
        $response->assertStatus(403);


    }

}
