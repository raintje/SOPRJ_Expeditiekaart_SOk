<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function firstLayerItems()
    {
        return $this->belongsToMany(
          FirstLayerItem::class,
            'categories_first_layer_items',
            'category_id',
            'first_layer_item_id');
    }
}
