<?php

namespace App\Http\Helpers;  //this was missing in your code

use App\Models\LayerItem;

class BDEncoder {

  private const SEPERATOR = ';';

  public static function encode($items) {
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

  public static function decode($breadcrumb){
    if($breadcrumb == ''){
      return [];
    }

    $itemIDs = explode(self::SEPERATOR, $breadcrumb);
    $items = [];

    foreach($itemIDs as $itemId){
      $item = LayerItem::findOrFail($itemId);
      array_push($items, $item);
    }

    return $items;
  }
}

?>