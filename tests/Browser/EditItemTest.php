<?php

namespace Tests\Browser;

use App\Models\FirstLayerItem;
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
     * Takes a random item and tries to input invalid data.
     * @return void
     */
    public function testEditValidation() {
        //TODO
    }

    /**
     * Asserts if the item's old data is correctly displayed on the page.
     * @return void
     */
    public function testEditOldData() {
        //TODO
    }

    /**
     * Asserts if the page correctly displays a newly selected linked item.
     * @return void
     */
    public function testThree() {
        //TODO
    }

}
