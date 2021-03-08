<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $attributes = [
        'id',
        'name',
        'type',
        'path'
    ];

    protected $casts = [
        'date_uploaded' => 'datetime',
    ];

    public function layerItem() {
        return $this->hasOne(LayerItem::class);
    }

}
