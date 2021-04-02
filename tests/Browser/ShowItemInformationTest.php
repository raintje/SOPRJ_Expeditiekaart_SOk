<?php

namespace Tests\Browser;

use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItemsLayerItems;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowItemInformationTest extends DuskTestCase
{

    public function testCanDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/' . strval(File::first()->layer_item_id))
                    ->clickLink('Download')
                    ->assertPathBeginsWith('/files/');
        });
    }

    public function testLinkedItem()
    {
        $this->browse(function (Browser $browser) {
            $value = $browser->visit('/items/' . strval(LayerItemsLayerItems::first()->id))
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
                    ->assertPathIs('/items/' . strval(FirstLayerItem::first()->id) . '/edit');
        });
    }

    public function testCanDeleteItem(){
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/' . strval(FirstLayerItem::first()->id))
                    ->clickLink('Verwijderen')
                    ->click('@modal-delete-button')
                    ->assertPathIs('/items/'. strval(FirstLayerItem::first()->id) . '/delete')
                    ->assertSee('Het item is succesvol verwijderd!')
                    ->clickLink('Terug naar de expeditiekaart')
                    ->assertPathIs('/');
        });
    }
}
