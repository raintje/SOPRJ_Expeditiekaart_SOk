<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\File;
use App\Models\LayerItem;
use App\Models\FirstLayerItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
     * Tests going to existing item works.
     * @return void
     */
    public function test_going_to_existing_item_works()
    {
        $layerItem = LayerItem::all()->last();
        $response = $this->get(route('show.item', $layerItem->id));
        $response->assertStatus(200);
    }

    /**
     * Tests going to non existing item returns 404.
     * @return void
     */
    public function test_going_to_non_existing_item_gives_404_on_show()
    {
        $layerItem = LayerItem::all()->last();
        $response = $this->get(route('show.item', ($layerItem->id+1)));
        $response->assertStatus(404);
    }

    /**
     * Tests if not existing item gives 404.
     * @return void
     */
    public function test_not_existing_item_gives_404_on_destroy()
    {
        $user = User::first();
        Auth::login($user);
        $layerItem = LayerItem::all()->last();
        $response = $this->get(route('destroy.item', ($layerItem->id+1)));
        $response->assertStatus(404);
    }

    /**
     * Tests if existing item can be destroyed.
     * @return void
     */
    public function test_existing_item_can_be_destroyed()
    {
        $user = User::first();
        Auth::login($user);
        $layerItem = LayerItem::factory()->create();
        $this->get(route('destroy.item', $layerItem->id));
        $layerItem = LayerItem::find($layerItem->id);
        $this->assertTrue($layerItem == null);
    }

    /**
     * Tests if existing item with firstLayerItem can be destroyed.
     * @return void
     */
    public function test_existing_item_with_firstLayerItem_can_be_destroyed()
    {
        $user = User::first();
        Auth::login($user);
        $layerItem = LayerItem::factory()->create();
        $firstLayerItem = FirstLayerItem::factory()->create(['layer_item_id' => $layerItem->id]);
        $this->get(route('destroy.item', $layerItem->id));
        $layerItem = LayerItem::find($layerItem->id);
        $firstLayerItem = FirstLayerItem::find($firstLayerItem->id);
        $this->assertTrue($layerItem == null && $firstLayerItem == null);
    }

    /**
     * Tests if existing item with a file can be destroyed.
     * @return void
     */
    public function test_existing_item_with_file_can_be_destroyed()
    {
        $user = User::first();
        Auth::login($user);
        $layerItem = LayerItem::factory()->create();
        $file = File::factory()->create(['layer_item_id' => $layerItem->id]);
        $this->get(route('destroy.item', $layerItem->id));
        $layerItem = LayerItem::find($layerItem->id);
        $file = File::find($file->id);
        $this->assertTrue($layerItem == null && $file == null);
    }



}
