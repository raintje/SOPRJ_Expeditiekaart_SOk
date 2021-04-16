<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstLayerItem extends Model
{
    use HasFactory;


    protected $fillable = ['id', 'layer_item_id', 'x_pos', 'y_pos'];

    public function layerItem()
    {
        return $this->hasOne(LayerItem::class, 'id', 'layer_item_id');
    }
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'categories_first_layer_items',
            'first_layer_item_id',
            'category_id');
    }
}
