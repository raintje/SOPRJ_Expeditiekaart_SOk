<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layer2Item extends Model
{

    use HasFactory;

    protected $attributes = [
        'id',
        'title',
        'description'
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'date_updated' => 'datetime'
    ];
}
