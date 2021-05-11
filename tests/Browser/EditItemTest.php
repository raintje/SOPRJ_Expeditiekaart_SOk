<?php

namespace Tests\Browser;

use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\User;
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
    public function testEditValidation()
    {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());
            $browser->loginAs(User::find(1))
                ->visitRoute('edit.item', $item->id)
                    ->type('title', '')
                    ->press('Wijzigingen opslaan')
                    ->assertPathIs('/items/' . $item->id . '/edit')
                    ->assertSeeIn('@error-container', 'De titel van een item is verplicht.')
                    ->type('title', $this->faker()->randomElement(LayerItem::all()->where('id', '!=', $item->id))->title)
                    ->press('Wijzigingen opslaan')
                    ->assertPathIs('/items/' . $item->id . '/edit')
                    ->assertSeeIn('@error-container', 'De titel moet uniek zijn.');
        });
    }

    /**
     * Asserts if the item's old data is correctly displayed on the page.
     * @return void
     */
    public function testEditOldData()
    {
        $this->browse(function (Browser $browser) {

            // Grabs a random LayerItem from the database.
            $item = $this->faker()->randomElement(LayerItem::all());

            // Grabs the FirstLayerItem related to the selected LayerItem.
            $firstLayerItem = FirstLayerItem::with('categories')->where('layer_item_id', $item->id)->first();

            // Asserts if the title and body of the item are displayed in the correct location.
            $browser->loginAs(User::find(1))
                ->visitRoute('edit.item', $item->id)
                    ->assertInputValue('title', $item->title)
                    ->assertInputValue('body', $item->body);

            // Asserts if the item's categories are correctly checked.
            foreach ($firstLayerItem->categories as $category) {
                $field = '@categories-' . $category->id;
                $browser->visitRoute('edit.item', $item->id)
                        ->assertChecked($field);
            }

            // Asserts if the titles of linked items are displayed on the page.
            foreach ($item->referencesLayerItems as $item) {
                $browser->visitRoute('edit.item', $item->id)
                        ->assertSee($item->title);
            }
        });
    }

    /**
     * Tries to edit and save an item, complying with the validation rules.
     * @return void
     */
    public function testEditItemSave()
    {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());
            $browser->loginAs(User::find(1))
                    ->visitRoute('edit.item', $item->id)
                    ->assertPathIs('/items/' . $item->id . '/edit')
                    ->type('title', $this->faker->text(20))
                    ->check('@categories-' . random_int(1, 3))
                    ->press('Wijzigingen opslaan')
                    ->assertPathIs('/items/' . $item->id);
        });
    }
}
