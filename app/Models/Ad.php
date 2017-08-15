<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name', 'type', 'position', 'code', 'image', 'url', 'start_date', 'end_date', 'status', 'lang',
    ];
}
