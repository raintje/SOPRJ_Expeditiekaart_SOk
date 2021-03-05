<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class files extends Model
{
    use HasFactory;

    protected $attributes = [
        'name',
        'type',
        'path'
    ];

    protected $casts = [
        'date_uploaded' => 'datetime',
    ];

}
