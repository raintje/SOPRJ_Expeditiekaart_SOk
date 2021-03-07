<?php

namespace App\Http\Controllers;

use App\Models\FirstLayerItem;
use Illuminate\Http\Request;

class FirstLayerItemController extends Controller
{
    public function all()
    {
        $layerItems = FirstLayerItem::all();
        return $layerItems;
    }
}
