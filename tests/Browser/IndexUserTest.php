<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class IndexUserTest extends DuskTestCase
{
    /**
     * Checks if the button for the create page is displayed correctly and redirects to the correct route.
     * @group index.user
     * @return void
     */
    public function testCreateButtonDirectsToCorrectPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(31));
            $browser->visit('/users');
            $browser->assertSee('Gebruiker toevoegen');
            $browser->press('Gebruiker toevoegen');
            $browser->assertPathIs('/users/create');
        });
    }
}
