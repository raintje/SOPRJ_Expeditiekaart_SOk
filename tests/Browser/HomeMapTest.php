<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeMapTest extends DuskTestCase
{
    /**
     * @group map
     */
    public function testHasMap()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('.vue2leaflet-map')
                ->assertVisible('.leaflet-container')
                ->assertVisible('.leaflet-touch');
        });
    }

    /**
     * @group map
     */
    public function testItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVueIsNot('items', '', '@home-component');
        });
    }

    /**
     * @group map
     */
    public function testHasNav()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('.Nav--right');
        });
    }

    /**
     * @group map
     */
    public function testHasNavButtonDesktop()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertVisible('#NavButton');
        });
    }

    /**
     * @group map
     */
    public function testHasNavButtonMobile()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(360, 640);
            $browser->visit('/')
                ->assertVisible('#NavButton');
        });
    }

    /**
     * @group map
     */
    public function testHasNavItemsMobile()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(360, 640);
            $browser->press('#NavButton')
                ->pause(1000)
                ->assertSee("Account")
                ->assertSee("Dashboard")
                ->assertSee("Item toevoegen");
        });
    }
}
