<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CreateUserTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Tries to create a user without any information and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnEmpty() {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                    ->visit('/users/create')
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('De naam van de gebruiker kan niet leeggelaten worden.')
                    ->assertSee('Het emailadres van de gebruiker kan niet leeggelaten worden.');
        });

        $user->delete();
    }

    /**
     * Tries to create a user with an incorrect email adress and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnInvalidEmail() {

        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs(User::first())
                    ->visit('/users/create')
                    ->type('name', $this->faker->name)
                    ->type('email', 'aaaa')
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('Voer alstublieft een geldig emailadres in.');
        });

        $user->delete();
    }

    /**
     * Tries to create a duplicate user and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnDuplicateUser() {

        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user) {
            $randomUser = $this->faker->randomElement(User::all());
            $browser->loginAs($user)
                    ->visit('/users/create')
                    ->type('name', $randomUser->name)
                    ->type('email', $randomUser->email)
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('Er bestaat al een account met dit emailadres.');
        });

        $user->delete();
    }

    /**
     * Tries to create a new user and asserts if the insertion was succesful
     * @group create.user
     * @return void
     */
    // public function testSuccesfulUserCreation() {
    //     $this->browse(function (Browser $browser) {
    //         $randomName = $this->faker->name;
    //         $randomEmail = 'laraveldusktestadres@gmail.com';
    //         $browser->loginAs(User::first())
    //                 ->visit('/users/create')
    //                 ->type('name', $randomName)
    //                 ->type('email', $randomEmail)
    //                 ->press('Gebruiker aanmaken')
    //                 ->assertPathIs('/users');
    //     });
    // }

}
