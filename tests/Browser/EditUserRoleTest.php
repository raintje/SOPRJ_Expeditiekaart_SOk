<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Spatie\Permission\Models\Role;
use Tests\DuskTestCase;

class EditUserRoleTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Navigates to the page and asserts if an element is correctly displayed.
     *
     * @group edit.userrole
     * @return void
     */
    public function testSelectIsDisplayed()
    {
        $this->browse(function (Browser $browser) {
            $ranUser = $this->faker()->randomElement(User::all()->pluck('id'));
            $browser->loginAs(User::first())
                    ->visitRoute('users.edit', ['user' => $ranUser])
                    ->assertPathIs('/users/' . $ranUser . '/edit')
                    ->assertVisible('@role-select');
        });
    }

    /**
     * Navigates to the page and asserts if the select list contains the correct data.
     * @group edit.userrole
     * @return void
     */
     public function testSelectContainsRoles()
     {
         $this->browse(function (Browser $browser) {
             $ranUser = $this->faker()->randomElement(User::all()->where('name', '!=', 'admin'));
             $roles = Role::all()->where('name', '!=', 'super admin')->pluck('id')->toArray();
             $browser->loginAs(User::first())
                     ->visitRoute('users.edit', ['user' => $ranUser->id])
                     ->assertPathIs('/users/' . $ranUser->id . '/edit')
                     ->assertSelectHasOptions('@role-select', $roles);
         });
     }

    /**
     * Navigates to the page and asserts if the select list's current value is equal to a random user's current role.
     * @group edit.userrole
     * @return void
     */
    public function testSelectValueIsOldRole()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user) {
            $ranUser = $this->faker()->randomElement(User::all());
            $userRole = $ranUser->roles->first();
            $browser->loginAs($user)
                    ->visitRoute('users.edit', ['user' => $ranUser->id])
                    ->assertPathIs('/users/' . $ranUser->id . '/edit')
                    ->assertValue('@role-select', $userRole->id);
        });


    }
}
