<?php

namespace Tests\Unit;

use App\Http\Helpers\BDEncoder;
use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;
use Tests\TestCase;


class BreadcrumbTest extends TestCase
{
    
    /**
     * A test to see if the breadcrumb correctly handels incorrect path
     * 
     * @return void
     */
    public function testBreadcrumbShouldFail() : void
    {
        $incorrectPath = 'should fail';
        
        $response = $this->get(route('breadcrumb.add', ['id' => Layeritem::first()->id, 'breadcrumb' => $incorrectPath]));
        $response->assertStatus(404);
    }

    /**
     * A test to see if an the breadcrumb can be updated
     * 
     * @return void
     */
    public function testBreadcrumbShouldUpdate()
    {
        $linkItem = LayerItemsLayerItems::first();
        
        $bdPath = $linkItem->layer_item_id . BDEncoder::SEPERATOR . $linkItem->linked_layer_item_id;
   
        $response = $this->get(route('breadcrumb.update', ['id' => $linkItem->linked_layer_item_id, 'breadcrumb' => $bdPath, 'returnNr' => 0]));
        $response->assertRedirect(route('show.item', ['id' => $linkItem->linked_layer_item_id]));
        $response->assertStatus(302);
    }

    /**
     * A test to see if an item can be added to the breadcrumb
     * 
     * @return void
     */
    public function testBreadcrumbShouldAdd() : void
    {
        $linkItem = LayerItemsLayerItems::first();

        $response = $this->get(route('breadcrumb.add', ['id' => $linkItem->linked_layer_item_id, 'breadcrumb' => $linkItem->layer_item_id]));
        $response->assertViewIs('items.show');
        $response->assertStatus(200);
    }

    /**
     * A test to see if the breadcrumb is correctly handled after the links is deleted
     * 
     * @return void
     */
    public function testBreadcrumbRemoveAddedTest() : void
    {
        $linkItem = LayerItemsLayerItems::first();
        
        $response = $this->get(route('breadcrumb.add', ['id' => $linkItem->linked_layer_item_id, 'breadcrumb' => $linkItem->layer_item_id]));
        $response->assertStatus(200);

        $linkItem->delete();

        $response = $this->get(route('breadcrumb.add', ['id' => $linkItem->linked_layer_item_id, 'breadcrumb' => $linkItem->layer_item_id]));
        $response->assertStatus(404);

        $linkItem->save();
    }

}
