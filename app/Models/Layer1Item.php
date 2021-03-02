<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layer1Item extends Model
{
    Protected $attributes = [
        'title',
        'description',
        'body',
        'xLocation',
        'yLocation',
        'UserIdOfWriter'
    ];

    protected $casts = [

    ];
}
