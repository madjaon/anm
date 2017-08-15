<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTypeRelation extends Model
{
    protected $fillable = [
        'post_id', 'type_id',
    ];
    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
    public function posttype() 
    {
        return $this->belongsTo('App\Models\PostType', 'type_id', 'id');
    }
}
