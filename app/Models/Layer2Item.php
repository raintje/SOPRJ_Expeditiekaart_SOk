<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Layer2Item extends Model
{
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
