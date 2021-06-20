<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LayerItem;

class LayerItemController extends Controller
{
  public function AllLayerItems(): array
  {
    return LayerItem::where('level', '>', 1)
      ->get()
      ->jsonSerialize();
  }
}
