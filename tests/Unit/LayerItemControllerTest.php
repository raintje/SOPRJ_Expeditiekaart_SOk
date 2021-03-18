<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\LayerItem;
use App\Models\FirstLayerItem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class LayerItemControllerTest extends TestCase
{

    use WithFaker;

    protected function setUpFaker() 
    {
        $this->faker = $this->makeFaker('nl_NL');
    }

    /**
     * Tests if all the information from the database is correctly parsed to a list.
     * @return void
     */
    public function test_layeritems_are_present_in_database()
    {
        $haystack = LayerItem::all();
        $id = rand(1, 10);
        $this->assertContains($haystack->find($id), $haystack);
    }

    /**
     * Tests if we return an error when selecting an out of bounds item
     * expected failure
     * @return void
     */
    public function test_layeritems_out_of_bounds_returns_error() 
    {
        $haystack = LayerItem::all();
        $id = 99999;
        $this->assertContains($haystack->find($id), $haystack);
    }

    /**
     * Tests if all the information from the database is correctly parsed to a list.
     * @return void
     */
    public function test_categories_are_present_in_database() 
    {
        $haystack = Category::all();
        $id = rand(1, 3);
        $this->assertContains($haystack->find($id), $haystack);
    }

    /**
     * Tests if we return an error when selecting an out of bounds item
     * expected failure
     * @return void
     */
    public function test_category_out_of_bounds_returns_error() 
    {
        $haystack = Category::all();
        $id = 9999;
        $this->assertContains($haystack->find($id), $haystack);
    }

    /**
     * Tests if nothing goes wrong when data is applied to a model class.
     * @return void
     */
    public function test_saved_data_equals_old_data()
    {
        $testbody = $this->faker('nl_NL')->text;
        $mock = new LayerItem();
        $mock->body = $testbody;  
        $this->assertTrue($mock->body == $testbody);
    }

    /**
     * Tests if the given ID gets attached to the model.
     * @return void
     */
    public function test_category_id_gets_attached_to_model() 
    {
        $category = $this->faker->randomElement(Category::all()->pluck('id')->toArray());
        $mock = new FirstLayerItem();
        $mock->layer_item_id = $category;
        $this->assertTrue($mock->layer_item_id == $category);
    }

}
