<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'code', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'facebook_app_id', 'top_day', 'top_week', 'top_month', 'top_quarter', 'top_year', 'top_total', 'top_season', 'top_trending', 'credit', 'status', 'lang',
    ];
    
}
