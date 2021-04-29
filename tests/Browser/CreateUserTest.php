<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateUserTest extends DuskTestCase
{
    /**
     * Tries to create a user without any information and asserts if the error messages are displayed correctly.
     * @group create.user
     * @return void
     */
    public function testValidationOnEmpty() {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/create')
                    ->press('Gebruiker aanmaken')
                    ->assertPathIs('/users/create')
                    ->assertSee('De naam van de gebruiker kan niet leeggelaten worden.')
                    ->assertSee('Het emailadres van de gebruiker kan niet leeggelaten worden.');
        });
    }



}
