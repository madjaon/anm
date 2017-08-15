<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    protected $fillable = [
        'name', 'slug', 'patterns', 'parent_id', 'relation_id', 'level', 'position', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'limited', 'sort_by', 'home', 'type', 'display', 'list_posts', 'grid', 'color', 'status', 'lang',
    ];
    public function posttyperelations()
    {
        return $this->hasMany('App\Models\PostTypeRelation', 'type_id', 'id');
    }
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'post_type_relations', 'type_id', 'post_id');
    }
}
