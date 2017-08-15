<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostEp extends Model
{
    protected $fillable = [
        'name', 'slug', 'post_id', 'epchap', 'server0', 'server1', 'server2', 'server3', 'server4', 'server5', 'summary', 'description', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'position', 'start_date', 'view', 'status', 'lang',
    ];
    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
}
