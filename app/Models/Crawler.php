<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    protected $fillable = [
        'name', 'source', 'slug_type', 'post_slugs', 'title_type', 'post_titles', 'post_links', 'category_link', 'category_page_link', 'category_page_start', 'category_page_end', 'category_post_link_pattern', 'type_main_id', 'type', 'image_dir', 'image_pattern', 'image_check', 'title_post_check', 'title_pattern', 'description_pattern', 'description_pattern_delete', 'element_delete', 'element_delete_positions', 'count_get', 'time_get', 'start_date', 'status', 
    ];
}
