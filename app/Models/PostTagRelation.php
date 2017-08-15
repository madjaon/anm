<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTagRelation extends Model
{
    protected $fillable = [
        'post_id', 'tag_id',
    ];
    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
    public function posttag() 
    {
        return $this->belongsTo('App\Models\PostTag', 'tag_id', 'id');
    }
}
