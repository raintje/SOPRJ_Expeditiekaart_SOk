<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SuperAdminDashboardTest extends DuskTestCase
{
    /**
     * Navigates to the webpages and asserts if all the elements are rendered correctly.
     *
     * @return void
     */
    public function testPageElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::first());
        });
    }
}
