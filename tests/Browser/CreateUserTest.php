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
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(31))
                    ->visit('/users/create')
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('De naam van de gebruiker kan niet leeggelaten worden.')
                    ->assertSee('Het emailadres van de gebruiker kan niet leeggelaten worden.');
        });
    }

    /**
     * Tries to create a user with an incorrect email adress and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnInvalidEmail() {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(31))
                    ->visit('/users/create')
                    ->type('name', $this->faker->name)
                    ->type('email', 'aaaa')
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('Voer alstublieft een geldig emailadres in.');
        });
    }

    /**
     * Tries to create a duplicate user and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnDuplicateUser() {
        $this->browse(function (Browser $browser) {
            $randomUser = $this->faker->randomElement(User::all());
            $browser->loginAs(User::find(31))
                    ->visit('/users/create')
                    ->type('name', $randomUser->name)
                    ->type('email', $randomUser->email)
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('Er bestaat al een account met dit emailadres.');
        });
    }

    /**
     * Tries to create a new user and asserts if the insertion was succesful
     * @group create.user1
     * @return void
     */
    public function testSuccesfulUserCreation() {
        $this->browse(function (Browser $browser) {
            $randomName = $this->faker->name;
            $randomEmail = $this->faker->unique()->email;
            $browser->loginAs(User::find(31))
                    ->visit('/users/create')
                    ->type('name', $randomName)
                    ->type('email', $randomEmail)
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users');
        });
    }

}
