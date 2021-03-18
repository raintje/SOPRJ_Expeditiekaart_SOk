<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayerItem extends Model
{
    use HasFactory;


    //if function does not work properly(is reversed), than change to commented line
    public function referencesLayerItems()
    {
        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'layer_item_id', 'linked_layer_item_id');
//        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'linked_layer_item_id', 'layer_item_id');
    }

    public function isReferencedLayerItems()
    {
//        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'layer_item_id', 'linked_layer_item_id');
        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'linked_layer_item_id', 'layer_item_id');
    }
}
