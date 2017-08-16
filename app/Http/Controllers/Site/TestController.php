<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Models\Post;

use Sunra\PhpSimple\HtmlDomParser;

class TestController extends Controller
{
    public function index()
    {
        // return view('site.test');

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

    /**

    CREATE TABLE `ani_anilists` (
      `id` int(11) NOT NULL,
      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `name2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `year` int(11) NOT NULL,
      `season` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `episode` int(11) NOT NULL,
      `type` int(11) NOT NULL,
      `kind` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `genre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='test';

    ALTER TABLE `ani_anilists` ADD PRIMARY KEY (`id`);

    ALTER TABLE `ani_anilists` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

    **/

    public function animeSteal(Request $request)
    {
        trimRequest($request);

        $html = HtmlDomParser::str_get_html($request->htmlstring); // Create DOM from URL or file

        $genres = [];
        $titles = [];
        $producers = [];
        $eps = [];

        foreach($html->find('.seasonal-anime') as $element) {
            $genres[] = trim($element->getAttribute('data-genre'));
        }
        foreach($html->find('.title-text') as $element) {
            $titles[] = trim($element->plaintext);
        }
        foreach($html->find('span.producer') as $element) {
            $producers[] = trim($element->plaintext);
        }
        foreach($html->find('div.eps') as $element) {
            $eps[] = str_replace(' eps', '', trim($element->plaintext));
        }

        if(count($titles) > 0) {
            foreach($titles as $key => $value) {
                DB::table('anilists')->insert([
                    'name' => $value, // ten phim
                    // 'name2' => '', // ten khac
                    'year' => $request->year, // nam
                    'season' => $request->season, // mua
                    'episode' => $eps[$key], // so tap
                    'type' => $request->type, // loai phim
                    'kind' => $request->kind, // tinh trang
                    'tag' => $producers[$key], // hang phim
                    'genre' => $genres[$key] // the loai
                ]);
            }
        }
        return redirect('test')->with('success', 'Thành công');
        // dd('success!');
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