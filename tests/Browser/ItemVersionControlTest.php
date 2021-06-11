<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use App\Models\User;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ItemVersionControlTest //extends DuskTestCase
{


    use WithFaker;

    protected function setUpFaker()
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testHistoryRestoration()
    {

        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');
        $prevText = null;
        $usedItem =  $this->faker()->randomElement(LayerItem::all());;
        $this->browse(function (Browser $browser) use ($usedItem, $prevText, $user) {
            $item = $usedItem;
            $browser->loginAs($user)
                ->visitRoute('edit.item', $item->id)
                ->assertPathIs('/items/' . $item->id . '/edit')
                ->type('title', $this->faker->text(20))
                ->check('@categories-' . random_int(1, 3))
                ->press('Wijzigingen opslaan')
                ->assertPathIs('/items/' . $item->id);
            $prevText = $browser->visitRoute('show.item', $usedItem->id)->text('#item--title');
            $browser->loginAs($user)
                ->visitRoute('show.item', $usedItem->id)
                ->assertSee('Voorgaande aanpassingen weergeven')
                ->press('#showHistory')
                ->waitFor('#res--itemhistory')
                ->press('#res--itemhistory');
               $this->assertNotEquals($browser->visitRoute('show.item', $usedItem->id)->text('#item--title'), $prevText);
        });
        $user->delete();
    }

    public function testHistoryDeletion()
    {

        $user = User::factory()->create([
            'email' => $this->faker->email,
        ]);
        $user->assignRole('super admin');
        $prevText = null;
        $usedItem =  $this->faker()->randomElement(LayerItem::all());;
        $this->browse(function (Browser $browser) use ($usedItem, $prevText, $user) {
            $item = $usedItem;
            $browser->loginAs($user)
                ->visitRoute('edit.item', $item->id)
                ->assertPathIs('/items/' . $item->id . '/edit')
                ->type('title', $this->faker->text(20))
                ->check('@categories-' . random_int(1, 3))
                ->press('Wijzigingen opslaan')
                ->assertPathIs('/items/' . $item->id);
            $browser->visitRoute('show.item', $usedItem->id);
            $elements = $browser->driver->findElements(WebDriverBy::className('history--item'));
            $prevCount = count($elements);
            $browser->loginAs($user)
                ->visitRoute('show.item', $usedItem->id)
                ->assertSee('Voorgaande aanpassingen weergeven')
                ->press('#showHistory')
                ->waitFor('#del--itemhistory')
                ->press('#del--itemhistory');
            $browser->visitRoute('show.item', $usedItem->id);
            $this->assertNotEquals($browser->driver->findElements(WebDriverBy::className('history--item')), $prevCount);
        });
        $user->delete();
    }
}
