<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;


class IndexUserTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Checks if the button for the create page is displayed correctly and redirects to the correct route.
     * @group index.user
     * @return void
     */
    public function testCreateButtonDirectsToCorrectPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(31))
                    ->visit('/users')
                    ->assertSee('Gebruiker toevoegen')
                    ->press('Gebruiker toevoegen')
                    ->assertPathIs('/users/create');
        });
    }

    /**
     * Selects a random user and asserts if the 
     * @group index.user
     * @return void
     */
    public function testUsersAreDisplayed() {
        $this->browse(function (Browser $browser) {
            $randomUser = $this->faker->randomElement(User::all());
            $browser->loginAs(User::find(31))
                    ->visit('/users')
                    ->pause(500)
                    ->select('usersTable_length', 100)
                    ->assertSelected('usersTable_length', 100)
                    ->pause(100)
                    ->assertSee($randomUser->email)
                    ->assertSee($randomUser->name);
        });
    }
}
