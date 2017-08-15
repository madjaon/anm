<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'name', 'type', 'url', 'position', 'image', 'status', 'lang',
    ];
}
