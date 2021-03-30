<?php

namespace Tests\Browser;

use Database\Seeders\LayerItemLayerItemSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowItemInformationTest extends DuskTestCase
{

    public function testCanDownload()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/1')
                    ->assertSeeLink("Download");
        });
    }
}
