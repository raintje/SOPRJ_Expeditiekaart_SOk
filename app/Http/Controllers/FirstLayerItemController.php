<?php

namespace App\Http\Controllers;

use App\Models\FirstLayerItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirstLayerItemController extends Controller
{
    public function all()
    {
        $items = FirstLayerItem::with('layerItem')->get();
//        dd($items);
        foreach ($items as $item) {
            $item->position = (['lng' => $item->x_pos, 'lat' => $item->y_pos]);
        }

        return $items;
    }

    public function saveLocations(Request $request)
    {
        foreach ($request->json()->all() as $item) {

            FirstLayerItem::where('id', $item['id'])
                ->update(array('x_pos' => $item['position']['lng'], 'y_pos' => $item['position']['lat']));

        }

        return response()
            ->json(['status' => 'success']);
    }
}
