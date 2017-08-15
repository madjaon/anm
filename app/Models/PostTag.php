<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $fillable = [
        'name', 'slug', 'patterns', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'status', 'lang', 'user_id',
    ];
    public function posttagrelations()
    {
        return $this->hasMany('App\Models\PostTagRelation', 'tag_id', 'id');
    }
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'post_tag_relations', 'tag_id', 'post_id');
    }
}
