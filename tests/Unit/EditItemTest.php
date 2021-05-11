<?php

namespace Tests\Unit;

use App\Http\Controllers\LayerItemController;
use App\Http\Requests\LayerItemEditRequest;
use App\Models\File;
use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EditItemTest extends TestCase
{
    /**
     * A test to see if the page is loaded correctly with view and status.
     *
     * @return void
     */
    public function testEditItemPageResponse()
    {
        $response = $this->get(route('edit.item', LayerItem::first()->id));
        $response->assertViewIs('items.edit');
        $response->assertStatus(200);
    }

    /**
     * A test to see if the returns 404 if route gets called without existing ID.
     *
     * @return void
     */
    public function testEditItemPageResponseWithWrongID()
    {
        $response = $this->get(route('edit.item', LayerItem::all()->last()->id + 1 ));
        $response->assertStatus(404);
    }

    /**
     * A test of the update method.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $id = LayerItem::first()->id;

        // create LayerItemEditRequest to pass parameter.
        $request = LayerItemEditRequest::create('/items/' . $id, 'POST', [
            'title' => 'foo',
            'body' => "<p>hoi</p>",
            'files[]' => UploadedFile::fake()->image('photo1.jpg'),
        ]);

        // create controller and execute update method.
        $controller = new LayerItemController();
        $response = $controller->update($request, $id);

        //Get statuscode and see if its expected
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * A test to see when a route gets called with wrong inputs, if it has errors.
     *
     * @return void
     */
    function testCanUpdatelayerItemWrongDataLocation()
    {
        $response = $this->post(route('update.item', ['id' => LayerItem::first()->id]), [
            'title' => null
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * A test to see when a route gets called with right inputs, if it has errors.
     *
     * @return void
     */
    function testCanUpdatelayerItemRightDataLocation()
    {
        $response = $this->post(route('update.item', ['id' => LayerItem::first()->id]), [
            'title' => 'Nice title',
            'body' => 'Body text',
        ]);

        $response->assertSessionHasNoErrors();
    }

    /**
     * A test to see if the appendix of an item can be deleted.
     *
     * @return void
     */
    public function testDeleteLayerItemAppendix(){
        $file = File::first();
        $id = $file->layer_item_id;

        $this->assertNotNull(File::where('id', $file->id));
        $controller = new LayerItemController();
        $response = $controller->deleteLayerItemAppendix($id, $file->id);

        $this->assertNull(File::find($file->id));
        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * A test to see if the linked item of an item can be deleted.
     *
     * @return void
     */
    public function testDeleteLinkedLayerItem(){
        $layerItem = LayerItemsLayerItems::first();


        $this->assertNotNull(LayerItemsLayerItems::where('id', $layerItem->id));
        $controller = new LayerItemController();
        $response = $controller->deleteLinkedLayerItem($layerItem->layer_item_id, $layerItem->linked_layer_item_id);

        $this->assertNull(LayerItemsLayerItems::find($layerItem->id));
        $this->assertEquals(302, $response->getStatusCode());
    }
}
