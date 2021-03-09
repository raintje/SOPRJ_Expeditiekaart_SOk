<?php

namespace App\Http\Controllers;

use App\Models\FirstLayerItem;
use Illuminate\Http\Request;

class FirstLayerItemController extends Controller
{
    public function all()
    {
        return FirstLayerItem::all();
    }
}
