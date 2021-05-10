<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BreadcrumbTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * @group map     
     * @group breadcrumb
     */
    public function testContainsLinks()
    {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());

            $browser->visitRoute('show.item', ['id' => $item])
                    ->assertSeeIn('@breadcrumb-list', 'Expeditiekaart')
                    ->assertSeeIn('@breadcrumb-list', $item->title);
        });
    }

    /**
     * @group map     
     * @group breadcrumb
     */
    public function testSeeUpdatedBreadcrumb()
    {
        $this->browse(function (Browser $browser) {
            $linkItem = $this->faker()->randomElement(LayerItemsLayerItems::all());
            
            $value = $browser->visitRoute('show.item', ['id' => $linkItem->layer_item_id])
                             ->text('@link-button');

            $browser->click('@link-button')
                    ->assertSeeIn('@breadcrumb-list', LayerItem::find($linkItem->layer_item_id)->title)
                    ->assertSeeIn('@breadcrumb-list', $value)
                    ->clickLink(LayerItem::find($linkItem->layer_item_id)->title)
                    ->assertSeeIn('@breadcrumb-list', LayerItem::find($linkItem->layer_item_id)->title)
                    ->assertDontSeeIn('@breadcrumb-list', $value);
        });
    }


}
