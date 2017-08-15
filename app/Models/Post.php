<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	//type: post, gallery, video...
	//url: link direct download...
    protected $fillable = [
        'name', 'slug', 'name2', 'patterns', 'type_main_id', 'seri', 'year', 'season', 'nation', 'type', 'kind', 'episode', 'url', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image', 'position', 'source', 'source_url', 'start_date', 'view', 'rating_value', 'rating_count', 'status', 'lang',
    ];
    public function posttyperelations()
    {
        return $this->hasMany('App\Models\PostTypeRelation', 'post_id', 'id');
    }
    public function posttypes()
    {
        return $this->belongsToMany('App\Models\PostType', 'post_type_relations', 'post_id', 'type_id');
    }
    public function posttagrelations()
    {
        return $this->hasMany('App\Models\PostTagRelation', 'post_id', 'id');
    }
    public function posttags()
    {
        return $this->belongsToMany('App\Models\PostTag', 'post_tag_relations', 'post_id', 'tag_id');
    }
}
