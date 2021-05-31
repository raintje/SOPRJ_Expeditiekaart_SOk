<?php

namespace Tests\Browser;

use App\Models\File;
use App\Models\FirstLayerItem;
use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use SebastianBergmann\Environment\Console;
use Tests\DuskTestCase;

class ShowItemInformationTest extends DuskTestCase
{

    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');

    }

    /**
     * @group showItem
     * @group editItems
     */
    public function testCanDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/' . strval(File::first()->layer_item_id))
                ->clickLink('Download')
                ->assertPathBeginsWith('/files/');
        });
    }

    /**
     * @group showItem
     * @group editItems
     * @group linkItem
     */
    public function testLinkedItem()
    {
        $this->browse(function (Browser $browser) {
            $value = $browser->visit('/items/' . strval(LayerItemsLayerItems::first()->id))
                             ->text('@link-button');

            $browser->click('@link-button')
                    ->assertSee($value);
        });
    }

    /**
     * @group showItem
     * @group editItems
     */
    public function testCanEditlink()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $item =LayerItem::first();
            $browser->loginAs(User::first())
                    ->visit('/items/' . strval($item->id))
                    ->click('@edit-button')
                    ->assertPathIs('/items/' . strval($item->id) . '/edit');
        });

        $user->delete();
    }

    /**
     * @group showItem
     * @group deleteItem
     */
    public function testCanDeleteItem()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');

        $this->browse(function (Browser $browser) use ($user){
            $item = LayerItem::first();
            $browser->loginAs($user)
                    ->visit('/items/' . strval($item->id))
                    ->clickLink('Verwijderen')
                    ->pause(500)
                    ->click('@modal-delete-button')
                    ->assertPathIs('/items/'. strval($item->id) . '/delete')
                    ->assertSee('Het item is succesvol verwijderd!')
                    ->clickLink('Terug naar de expeditiekaart')
                    ->assertPathIs('/');

            $item->save();
        });

        $user->delete();
    }

    /**
     * @group linkItem
     */
    public function testNonExistingLinkedItem()
    {
        $this->browse(function (Browser $browser) {
            $layerItem = LayerItem::all()->last();

            $browser->visit('/items/' . strval($layerItem->id + 1))
                    ->assertSee('404');
        });
    }

}
