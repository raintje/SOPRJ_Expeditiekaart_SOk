<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Panoscape\History\HasHistories;

class LayerItem extends Model
{
    use HasFactory;
    use HasHistories;
//    protected $guarded = [];

    public function getModelLabel()
    {
        return $this->display_name;
    }


    public function referencesLayerItems()
    {
        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'layer_item_id', 'linked_layer_item_id');
    }

    public function isReferencedLayerItems()
    {
        return $this->belongsToMany(LayerItem::class, 'layer_items_layer_items', 'linked_layer_item_id', 'layer_item_id');
    }

    public function history()
    {
        return $this->morphMany(History::class, 'layer_items', 'reference_table', 'reference_id');
    }
}
