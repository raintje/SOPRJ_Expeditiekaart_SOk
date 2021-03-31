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
     * TODO
     */
    public function testOne() {
        //TODO
    }

    /**
     * TODO
     */
    public function testTwo() {
        //TODO
    }

    /**
     * TODO
     */
    public function testThree() {
        //TODO
    }

}
