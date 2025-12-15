<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'name',
        'price',
        'cover',
        'status',
        'description',
        'rating'

    ];
}
