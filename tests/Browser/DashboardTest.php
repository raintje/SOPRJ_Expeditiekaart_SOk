<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{

    /**
     * Navigates to the webpage without logging in and asserts if we get redirected to the correct page.
     *
     * @group dashboard.tests
     * @return void
     */
    public function testPageIsAuthorized()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('dashboard')
                ->assertPathIs('/login')
                ->assertSee('Login')
                ->type('email', 'admin@gmail.com')
                ->type('password', 'Admin123!')
                ->press('Login')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Navigates to the webpage and asserts if all the elements are rendered correctly.
     *
     * @group dashboard.tests
     * @return void
     */
    public function testPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visitRoute('dashboard')
                ->assertPathIs('/dashboard');
        });
    }

    /**
     * Asserts if the dashboard buttons direct to the correct pages.
     *
     * @group dashboard.tests
     * @return void
     */
    public function testDashboardButtons() //TODO te lang wachten
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visitRoute('dashboard')
                ->assertPathIs('/dashboard')
                ->waitFor('@userButton')
                ->press('@userButton')
                ->assertPathIs('/users')
                ->back()
                ->waitFor('@itemButton')
                ->press('@itemButton')
                ->assertPathIs('/items')
                ->assertSee('Item overzicht');
        });
    }


    /**
     * Edits an item and asserts if the history is displayed on the dashboard.
     *
     * @group dashboard.tests
     * @return void
     */
    public function testHistoryDisplays()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first())
                ->visitRoute('edit.item', ['id' => LayerItem::first()->id])
                ->type('title', 'Dit is een testtitel.')
                ->press('@saveButton')
                ->visitRoute('dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('is aangepast door super admin admin');
        });
    }
}
