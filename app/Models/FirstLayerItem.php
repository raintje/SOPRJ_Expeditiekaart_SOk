<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstLayerItem extends Model
{
    use HasFactory;

    public function layerItem()
    {
        return $this->hasOne(LayerItem::class, 'id', 'layer_item_id');
    }
}
