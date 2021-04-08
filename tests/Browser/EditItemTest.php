<?php

namespace Tests\Browser;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EditItemTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Asserts if the validation is correctly applied to the title field.
     * @return void
     */
    public function testEditValidation() {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());
            $browser -> visit('/items/' . $item->id . '/edit' )
                     -> type('title', '')
                     -> press('Wijzigingen opslaan')
                     -> assertPathIs('/items/' . $item->id . '/edit')
                     -> assertSee('De titel van een item is verplicht.')
                     -> type('title', $item->title)
                     -> press('Wijzigingen opslaan')
                     -> assertPathIs('/items/' . $item->id . '/edit')
                     -> assertSee('De titel moet uniek zijn.');
        });
    }

    /**
     * Asserts if the item's old data is correctly displayed on the page.
     * @return void
     */
    public function testEditOldData() {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());
            $browser -> visit('/items/' . $item->id . '/edit')
                     -> assertSee($item->title)
                     -> assertSee($item->body);
        });
    }

    /**
     * Asserts if the page correctly displays a newly selected linked item.
     * @return void
     */
    public function testThree() {
        //TODO
    }

}
