<?php

namespace App\Http\Helpers;  //this was missing in your code

use App\Models\LayerItem;
use App\Models\LayerItemsLayerItems;

class BDEncoder {

  public const SEPERATOR = ';';

  public static function encode($items) 
  {
    $encoder = '';
    foreach($items as $item){
      $encoder .= $item->id;
      $encoder .= self::SEPERATOR;
    }

    if(strlen($encoder) > 0){
      $encoder = substr($encoder, 0, -1);
    }

    return $encoder;
  }

  public static function decode($breadcrumb)
  {
    if($breadcrumb == ''){
      return [];
    }

    $itemIDs = explode(self::SEPERATOR, $breadcrumb);
    $items = [];

    foreach($itemIDs as $itemId){
      $item = LayerItem::findOrFail($itemId);
      array_push($items, $item);
    }

    self::isCorrectLink($items);

    return $items;
  }

  public static function isCorrectLink($items)
  {
    for($i = 0; $i < (count($items) - 1); $i++){
      $parentItemId = $items[$i]->id;
      $childItemId = $items[$i+1]->id;
    
      LayerItemsLayerItems::where('layer_item_id', $parentItemId)->where('linked_layer_item_id', $childItemId)->firstOrFail();
    }
  }
}

?>