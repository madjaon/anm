<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSeri extends Model
{
	protected $table = 'post_series';

    protected $fillable = [
        'name', 'slug', 'patterns', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'position', 'status', 'lang',
    ];
}
