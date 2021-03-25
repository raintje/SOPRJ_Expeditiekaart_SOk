<?php

namespace App\Http\Controllers;

use App\Models\FirstLayerItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirstLayerItemController extends Controller
{
    public function all()
    {
        return FirstLayerItem::with('layerItem')->with('categories')->get();
    }

    public function saveLocations(Request $request)
    {
//        $counter = 1;
        foreach ($request->json()->all() as $item){

//            $editItem = FirstLayerItem::where('id', $item['id'])->first();
//            var_dump($editItem); die();
//            $editItem->layer_item_id = $item['layer_item_id'];
//            $editItem->x_pos = $item['x_pos'];
//            $editItem->y_pos = $item['y_pos'];
////                        var_dump($editItem->x_pos);die();
////            var_dump($editItem->save()->toSql());die();
////            $editItem->update([
////                'x_pos' => $item['x_pos'],
////                'y_pos' => $item['y_pos'],
////            ]);
//            $editItem->save();
////            $editItem->update($item[$counter]);

//            $counter++;
//            var_dump($item['x_pos']);die();
            FirstLayerItem::where('id', $item['id'])->update(array('x_pos' => $item['x_pos'], 'y_pos' => $item['y_pos'] ));
        }

//        $editItem = FirstLayerItem::where('id', 1)->first();
//        $editItem->x_pos = 530;
//        $editItem->y_pos = 446;
//        $editItem->save();



        return "succes";
    }
}
