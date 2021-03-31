<?php

namespace Tests\Browser;

use App\Models\FirstLayerItem;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowItemInformationTest extends DuskTestCase
{

    public function testCanDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/' . strval(FirstLayerItem::first()->id))
                    ->clickLink('Download')
                    ->assertPathBeginsWith('/files/');
        });
    }

    public function testLinkedItem()
    {
        $this->browse(function (Browser $browser) {
            $value = $browser->visit('/items/' . strval(FirstLayerItem::first()->id))
                             ->text('@link-button');
                             
            $browser->click('@link-button')
                    ->assertSee($value);
        });
    }

    public function testCanEditlink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/' . strval(FirstLayerItem::first()->id))
                    ->click('@edit-button')
                    ->assertPathIs('/items/1/edit');
        });
    }
}
