<?php

namespace Tests\Browser;

use App\Models\LayerItem;
use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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
     * @group test     
     * @group breadcrumb
     */
    public function testContainsLinks()
    {
        $this->browse(function (Browser $browser) {
            $item = $this->faker()->randomElement(LayerItem::all());

            $browser->visitRoute('show.item', ['id' => $item])
                    ->assertSeeIn('@breadcrumb-list', $item->title);

        });
    }

    /**
     * @group map     
     * @group breadcrumb
     */
    public function testLinkCanUpdate()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * @group map     
     * @group breadcrumb
     */
    public function testLinkCanFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * @group map     
     * @group breadcrumb
     */
    public function testLinkCanReturn()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
