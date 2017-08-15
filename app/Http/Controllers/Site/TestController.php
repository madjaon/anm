<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Models\Post;

class TestController extends Controller
{
    public function index()
    {
        dd('no permission');
        ////////////////////////////////////////
        //check posts va post_type_relations co trung du lieu hay ko
        // $posts = DB::table('posts')->lists('id');
        // $post_type_relations = DB::table('post_type_relations')->groupBy('post_id')->lists('post_id');
        // $count_posts = count($posts);
        // $count_post_type_relations = count($post_type_relations);
        // if($count_post_type_relations > 0 && $count_posts > 0) {
        //     foreach($post_type_relations as $value) {
        //         if(!in_array($value, $posts)) {
        //             echo $value . '<br>';
        //         }
        //     }
        // }
        // dd($count_post_type_relations);
        //END
        ////////////////////////////////////////
    }

    // warning: this function is dangerous
    // check bai viet trung nhau va lam 1 so thu khac
    // viet xong gio quen roi, doc lai code de biet
    //vlue = 28: type id 28. 
    public function mixdb($typeId=28)
    {
        dd('disabled');
        $ps = DB::table('posts')
                ->select('id', 'slug', 'type_main_id', DB::raw('COUNT(*) as c'))
                ->groupBy('slug')
                ->having('c', '>', 1)
                ->orderBy('c', 'desc')
                ->get();
        dd($ps);
        if(count($ps) > 0) {
            $ids = [];
            foreach($ps as $key => $value) {
                $ids[$key] = DB::table('posts')
                    ->where('slug', $value->slug)
                    ->lists('id');
                if(count($ids[$key]) > 0 && $value->c > 2) {
                    $firstId = $ids[$key][0];
                    $allbutfirst = array_slice($ids[$key], 1);
                    //delete post_type_relations
                    DB::table('post_type_relations')->whereIn('post_id', $ids[$key])->delete();
                    //insert post_type_relations with type = $typeId
                    DB::table('post_type_relations')->insert(['post_id' => $firstId, 'type_id' => $typeId]);
                    //delete posts duplicate posts except first in list
                    DB::table('posts')->whereIn('id', $allbutfirst)->delete();
                    //update first post typemainid = $typeId
                    DB::table('posts')->where('id', $firstId)->update(['type_main_id' => $typeId]);
                }
                if(count($ids[$key]) > 0 && $value->c == 2) {
                    $firstId = $ids[$key][0];
                    $secondId = $ids[$key][1];
                    //delete second post
                    DB::table('posts')->where('id', $secondId)->delete();
                    // update post type relation post id to first post id
                    DB::table('post_type_relations')->where('post_id', $secondId)->update(['post_id' => $firstId]);
                }
            }
            dd('End mix. Please, Check database now');
        } else {
            dd('no record');
        }
    }

}