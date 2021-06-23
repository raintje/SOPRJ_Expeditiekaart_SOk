<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayerItemsLayerItems extends Model
{
    use HasFactory;
    protected $table = 'layer_items_layer_items';
    protected $fillable = ['layer_item_id', 'linked_layer_item_id'];

    public function layerItem(){
        return $this->belongsTo(LayerItem::class, 'layer_item_id', 'id'); 
    }   

    public function linkedLayerItem(){
        return $this->belongsTo(LayerItem::class, 'linked_layer_item_id', 'id'); 
    }
}
