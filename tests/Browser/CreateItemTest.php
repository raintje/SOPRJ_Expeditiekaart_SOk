<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateItemTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testPageExists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/create')
                    ->assertSee('Items aanmaken');
        });
    }

    public function testValidationWithoutData()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/create')
                ->press('Opslaan')
                ->assertSee('De titel van een item is verplicht.')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });
    }

    public function testBodyValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/create')
                ->type('title', 'this is a testTitle')
                ->press('Opslaan')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });
    }

    public function testDuplicateItemCreation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/create')
                ->type('title', 'Voluptatem atque amet autem dicta blanditiis.')
                ->press('Opslaan')
                ->assertSee('De titel moet uniek zijn.')
                ->assertSee('De inhoud van het item mag niet leeg zijn.')
                ->assertPathIs('/items/create');
        });
    }

}
