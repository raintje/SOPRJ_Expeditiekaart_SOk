<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ChangeLocationMapTest extends DuskTestCase
{
    /**
     * @group map
     * @group changeLocation
     */
    public function testHasLocationMap()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('edit.item.location')
                ->assertVisible('.vue2leaflet-map')
                ->assertVisible('.leaflet-container')
                ->assertVisible('.leaflet-touch');
        });
    }

    /**
     * @group map
     * @group changeLocation
     */
    public function testLocationItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('edit.item.location')
                ->assertVueIsNot('items', '', '@editLocation-component');
        });
    }

    /**
     * @group map
     * @group changeLocation
     */
    public function testHasSaveButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('edit.item.location')
                ->assertVisible('#saveLocation');
        });
    }

    /**
     * @group map
     * @group changeLocation
     */
    public function testHasSaveButtonMobile()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(360, 640);
            $browser->visitRoute('edit.item.location')
                ->assertVisible('#saveLocation');
        });
    }

    /**
     * @group map
     * @group changeLocation
     */
    public function testSaveItems()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('edit.item.location')
                ->click('@save-button')
                ->pause(2000)
                ->assertVisible('.toast-body');
//                ->waitForText('De locaties zijn succesvol opgeslagen.');
        });
    }

    /**
     * @group map
     * @group changeLocation
     */
    public function testLegenda()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(360, 640);
            $browser->visitRoute('edit.item.location')
                ->assertVisible('.legend');
        });
    }




}