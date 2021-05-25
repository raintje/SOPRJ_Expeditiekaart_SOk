<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateRoleTest extends DuskTestCase
{
    /**
     * Asserts that the page is navigable.
     *
     * @group roles.create
     * @return void
     */
    public function testButtonNavigatesToPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visitRoute('users.index')
                    ->press('Rol aanmaken')
                    ->assertPathIs('/roles/create');
        });
    }

    /**
     * Asserts that validation errors are displayed upon not entering any data.
     * 
     * @group roles.create
     * @return void
     */
    public function testValidationIsDisplayedOnEmpty() 
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visitRoute('roles.create')
                    ->press('Rol opslaan')
                    ->assertRouteIs('roles.create')
                    ->assertSee('De naam van de rol kan niet leeggelaten worden.')
                    ->assertSee('Er moet minimaal 1 item geselecteerd worden');
        });
    }

    /**
     * Asserts that validation errors are displayed upon entering a name that's too long.
     * 
     * @group roles.create
     * @return void
     */
    public function testValidationIsDisplayedOnTooLongName()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                    ->visitRoute('roles.create')
                    ->type('name', str_repeat('a', 200))
                    ->press('Rol opslaan')
                    ->assertRouteIs('roles.create')
                    ->assertSee('Een naam mag maximaal 191 karakters lang zijn');
        });
    }

}
