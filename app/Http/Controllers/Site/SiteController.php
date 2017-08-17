<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use DB;
use App\Helpers\CommonMethod;
use App\Helpers\CommonOption;
use App\Helpers\CommonProvider;
use Validator;
use App\Models\Contact;

class SiteController extends Controller
{
    public function __construct()
    {
        CommonProvider::sharedata();
    }

    public function index()
    {
        //seo meta
        $seo = DB::table('configs')->where('status', ACTIVE)->first();

        if(!empty($seo->top_trending)) {
            $trending = explode(',', $seo->top_trending);
            // moi nhat
            $data = $this->getPosts()->whereNotIn('id', $trending)->take(PAGINATE_LATEST)->get();
        } else {
            // moi nhat
            $data = $this->getPosts()->take(PAGINATE_LATEST)->get();
        }

        // view
        // $data2 = $this->getPosts('view')->take(PAGINATE_HOT)->get();
        
        // return view
        return view('site.index', ['data' => $data, 'seo' => $seo]);
    }
    public function author(Request $request)
    {
        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;

        $data = DB::table('post_tags')
            ->join('post_tag_relations', 'post_tags.id', '=', 'post_tag_relations.tag_id')
            ->select('post_tags.id', 'post_tags.name', 'post_tags.slug', 'post_tags.image')
            ->where('post_tags.status', ACTIVE)
            ->groupBy('post_tag_relations.tag_id')
            ->paginate(PAGINATE);
        if($data->total() > 0) {
            // auto meta for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách hãng phim anime';
            if($page > 1) {
                $seo->meta_title = 'Danh sách hãng phim anime'.' trang '.$page;
            } else {
                $seo->meta_title = 'Danh sách hãng phim anime';
            }
            $seo->meta_keyword = 'hãng phim anime, hang phim anime';
            $seo->meta_description = 'Danh sách các hãng phim anime';
            $seo->meta_image = '/img/img600x315.jpg';
            
            // return view
            return view('site.post.author', ['data' => $data, 'seo' => $seo]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function tag(Request $request, $slug)
    {
        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        
        // query
        $tag = DB::table('post_tags')
            ->select('id', 'name', 'slug', 'patterns', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('status', ACTIVE)
            ->where('slug', $slug)
            ->first();
        // posts tags
        if(isset($tag)) {
            $tag->patterns = CommonMethod::replaceText($tag->patterns);
            $tag->summary = CommonMethod::replaceText($tag->summary);
            $tag->description = CommonMethod::replaceText($tag->description);
            $data = $this->getPostByRelationsQuery('tag', $tag->id)->paginate(PAGINATE);
            if($data->total() > 0) {
                // auto meta tag for seo
                // $tagName = ucwords(mb_strtolower($tag->name));
                $tagName = mb_convert_case($tag->name, MB_CASE_TITLE, "UTF-8");
                $tag->h1 = 'Hãng phim ' . $tagName;
                if(empty($tag->meta_title)) {
                    if($page > 1) {
                        $tag->meta_title = 'Xem anime của ' . $tagName.' trang '.$page;
                    } else {
                        $tag->meta_title = 'Xem anime của ' . $tagName;
                    }
                }
                if(empty($tag->meta_keyword)) {
                    // $tagNameNoLatin = CommonMethod::convert_string_vi_to_en($tagName);
                    // $tag->meta_keyword = $tagNameNoLatin.','.$tagName;
                    $tag->meta_keyword = $tagName;
                }
                if(empty($tag->meta_description)) {
                    $tag->meta_description = $tagName;
                }
                if(empty($tag->meta_image)) {
                    $tag->meta_image = '/img/img600x315.jpg';
                }

                $authors = $this->getTagsByPosts($data);

                // return view
                return view('site.post.tag', ['data' => $data, 'tag' => $tag, 'authors' => $authors]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function type(Request $request, $slug)
    {
        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        
        // query
        $type = DB::table('post_types')
            ->select('id', 'name', 'slug', 'patterns', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('status', ACTIVE)
            ->where('slug', $slug)
            ->first();
        // posts types
        if(isset($type)) {
            $type->patterns = CommonMethod::replaceText($type->patterns);
            $type->summary = CommonMethod::replaceText($type->summary);
            $type->description = CommonMethod::replaceText($type->description);
            $data = $this->getPostByRelationsQuery('type', $type->id)->paginate(PAGINATE);
            if($data->total() > 0) {
                // auto meta type for seo
                // $typeName = ucwords(mb_strtolower($type->name));
                $typeName = mb_convert_case($type->name, MB_CASE_TITLE, "UTF-8");
                $type->h1 = 'Thể loại ' . $typeName;
                if(empty($type->meta_title)) {
                    if($page > 1) {
                        $type->meta_title = 'Xem anime thể loại ' . $typeName.' trang '.$page;
                    } else {
                        $type->meta_title = 'Xem anime thể loại ' . $typeName;
                    }
                }
                if(empty($type->meta_keyword)) {
                    // $typeNameNoLatin = CommonMethod::convert_string_vi_to_en($typeName);
                    // $type->meta_keyword = $typeNameNoLatin.','.$typeName;
                    $type->meta_keyword = $typeName;
                }
                if(empty($type->meta_description)) {
                    $type->meta_description = $typeName;
                }
                if(empty($type->meta_image)) {
                    $type->meta_image = '/img/img600x315.jpg';
                }

                $authors = $this->getTagsByPosts($data);

                // return view
                return view('site.post.type', ['data' => $data, 'type' => $type, 'authors' => $authors]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function seri(Request $request, $slug)
    {
        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        
        // query
        $seri = DB::table('post_series')
            ->select('id', 'name', 'slug', 'patterns', 'summary', 'description', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('status', ACTIVE)
            ->where('slug', $slug)
            ->first();
        // posts seris
        if(isset($seri)) {
            $seri->patterns = CommonMethod::replaceText($seri->patterns);
            $seri->summary = CommonMethod::replaceText($seri->summary);
            $seri->description = CommonMethod::replaceText($seri->description);
            $data = $this->getPostBySeriQuery($seri->id)->paginate(PAGINATE);
            if($data->total() > 0) {
                // auto meta seri for seo
                // $seriName = ucwords(mb_strtolower($seri->name));
                $seriName = mb_convert_case($seri->name, MB_CASE_TITLE, "UTF-8");
                $seri->h1 = 'Seri anime ' . $seriName;
                if(empty($seri->meta_title)) {
                    if($page > 1) {
                        $seri->meta_title = 'Seri anime ' . $seriName.' trang '.$page;
                    } else {
                        $seri->meta_title = 'Seri anime ' . $seriName;
                    }
                }
                if(empty($seri->meta_keyword)) {
                    // $seriNameNoLatin = CommonMethod::convert_string_vi_to_en($seriName);
                    // $seri->meta_keyword = $seriNameNoLatin.','.$seriName;
                    $seri->meta_keyword = $seriName;
                }
                if(empty($seri->meta_description)) {
                    $seri->meta_description = $seriName;
                }
                if(empty($seri->meta_image)) {
                    $seri->meta_image = '/img/img600x315.jpg';
                }

                $authors = $this->getTagsByPosts($data);

                // return view
                return view('site.post.seri', ['data' => $data, 'seri' => $seri, 'authors' => $authors]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function nation(Request $request, $slug)
    {
        if(!in_array($slug, [SLUG_NATION_JAPAN, SLUG_NATION_USA, SLUG_NATION_KOREAN, SLUG_NATION_CHINA, SLUG_NATION_VIETNAM, SLUG_NATION_OTHER])) {
            return response()->view('errors.404', [], 404);
        }

        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        
        // query
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('nation', $slug)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        // posts
        if($data->total() > 0) {
            // auto meta for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách anime ' . CommonOption::getNation($slug);
            if($page > 1) {
                $seo->meta_title = 'Danh sách anime ' . CommonOption::getNation($slug) . 'hay nhất trang ' . $page;
            } else {
                $seo->meta_title = 'Danh sách anime ' . CommonOption::getNation($slug) . 'hay nhất';
            }
            $seo->meta_keyword = 'anime ' . CommonOption::getNation($slug);
            $seo->meta_description = 'Danh sách anime ' . CommonOption::getNation($slug) . ' hay nhất';
            $seo->meta_image = '/img/img600x315.jpg';

            $authors = $this->getTagsByPosts($data);

            // return view
            return view('site.post.box', ['data' => $data, 'seo' => $seo, 'authors' => $authors]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function kind(Request $request, $slug)
    {
        if(!in_array($slug, [SLUG_POST_KIND_FULL, SLUG_POST_KIND_UPDATING])) {
            return response()->view('errors.404', [], 404);
        }

        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        
        // query
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('kind', $slug)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        // posts
        if($data->total() > 0) {
            // auto meta for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách anime ' . CommonOption::getKindPost($slug);
            if($page > 1) {
                $seo->meta_title = 'Danh sách anime ' . CommonOption::getKindPost($slug) . ' trang ' . $page;
            } else {
                $seo->meta_title = 'Danh sách anime ' . CommonOption::getKindPost($slug);
            }
            $seo->meta_keyword = 'Danh sách anime ' . CommonOption::getKindPost($slug);
            $seo->meta_description = 'Danh sách anime ' . CommonOption::getKindPost($slug);
            $seo->meta_image = '/img/img600x315.jpg';

            $authors = $this->getTagsByPosts($data);

            // return view
            return view('site.post.box', ['data' => $data, 'seo' => $seo, 'authors' => $authors]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function year(Request $request, $slug)
    {
        if(!is_numeric($slug)) {
            return response()->view('errors.404', [], 404);
        }

        trimRequest($request);
        //check page
        $page = ($request->page)?$request->page:1;
        
        //query
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('year', $slug)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        // posts
        if($data->total() > 0) {
            //auto meta year for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách Anime năm ' .  $slug;
            if($page > 1) {
                $seo->meta_title = 'Xem Phim Anime vietsub năm ' . $slug . ' trang ' . $page;
            } else {
                $seo->meta_title = 'Xem Phim Anime vietsub năm ' . $slug;
            }
            $seo->meta_keyword = 'Xem Phim Anime vietsub ' . $slug . ', xem anime nam ' . $slug;
            $seo->meta_description = 'Xem Phim Anime vietsub ' . $slug . ' hay nhất';
            $seo->meta_image = '/img/img600x315.jpg';

            //return view
            return view('site.post.box', ['data' => $data, 'seo' => $seo]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function yearbefore(Request $request, $slug)
    {
        if(!is_numeric($slug)) {
            return response()->view('errors.404', [], 404);
        }
        
        trimRequest($request);
        //check page
        $page = ($request->page)?$request->page:1;
        
        //query
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('year', '<', $slug)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        // posts
        if($data->total() > 0) {
            //auto meta year for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách Anime trước năm ' .  $slug;
            if($page > 1) {
                $seo->meta_title = 'Xem Phim Anime vietsub trước năm ' . $slug . ' trang ' . $page;
            } else {
                $seo->meta_title = 'Xem Phim Anime vietsub trước năm ' . $slug;
            }
            $seo->meta_keyword = 'Xem Phim Anime vietsub trước năm ' . $slug . ', Xem Phim Anime truoc nam ' . $slug;
            $seo->meta_description = 'Xem Phim Anime vietsub trước năm ' . $slug . ' hay nhất';
            $seo->meta_image = '/img/img600x315.jpg';

            //return view
            return view('site.post.box', ['data' => $data, 'seo' => $seo]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function seasonYear(Request $request, $slug1, $slug2)
    {
        if(!in_array($slug1, [SLUG_SEASON_WINTER, SLUG_SEASON_SPRING, SLUG_SEASON_SUMMER, SLUG_SEASON_AUTUMN]) || !is_numeric($slug2)) {
            return response()->view('errors.404', [], 404);
        }

        trimRequest($request);
        //check page
        $page = ($request->page)?$request->page:1;
        
        //query
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('year', $slug2)
            ->where('season', $slug1)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('start_date', 'desc')
            ->paginate(PAGINATE);
        // posts
        if($data->total() > 0) {
            //auto meta year for seo
            $seo = new \stdClass();
            $seo->h1 = 'Danh sách Anime ' . CommonOption::getSeason($slug1) . ' năm ' . CommonOption::getYear($slug2);
            if($page > 1) {
                $seo->meta_title = 'Xem Phim Anime vietsub ' . CommonOption::getSeason($slug1) . ' năm ' . CommonOption::getYear($slug2) . ' trang ' . $page;
            } else {
                $seo->meta_title = 'Xem Phim Anime vietsub ' . CommonOption::getSeason($slug1) . ' năm ' . CommonOption::getYear($slug2);
            }
            $seo->meta_keyword = 'Xem Phim Anime vietsub ' . CommonOption::getSeason($slug1) . ' năm ' . CommonOption::getYear($slug2);
            $seo->meta_description = 'Xem danh sách Phim Anime vietsub ' . CommonOption::getSeason($slug1) . ' năm ' . CommonOption::getYear($slug2) . ' hay nhất';
            $seo->meta_image = '/img/img600x315.jpg';

            //return view
            return view('site.post.box', ['data' => $data, 'seo' => $seo]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function page($slug)
    {
        CommonMethod::forgetCache('/lien-he');
        CommonMethod::forgetCache('/contact');

        // IF SLUG IS PAGE
        // query
        $singlePage = DB::table('pages')->where('slug', $slug)->where('status', ACTIVE)->first();
        // page
        if(isset($singlePage)) {
            $singlePage->patterns = CommonMethod::replaceText($singlePage->patterns);
            $singlePage->summary = CommonMethod::replaceText($singlePage->summary);
            $singlePage->description = CommonMethod::replaceText($singlePage->description);

            // auto meta singlePage for seo
            // $singlePageName = ucwords(mb_strtolower($singlePage->name));
            $singlePageName = mb_convert_case($singlePage->name, MB_CASE_TITLE, "UTF-8");
            $singlePage->h1 = $singlePageName;
            if(empty($singlePage->meta_title)) {
                $singlePage->meta_title = $singlePageName;
            }
            if(empty($singlePage->meta_keyword)) {
                // $singlePageNameNoLatin = CommonMethod::convert_string_vi_to_en($singlePageName);
                // $singlePage->meta_keyword = $singlePageNameNoLatin.','.$singlePageName;
                $singlePage->meta_keyword = $singlePageName;
            }
            if(empty($singlePage->meta_description)) {
                $singlePage->meta_description = $singlePageName;
            }
            if(empty($singlePage->meta_image)) {
                $singlePage->meta_image = '/img/img600x315.jpg';
            }

            // return view
            return view('site.page', ['data' => $singlePage]);
        }

        // IF SLUG IS A POST
        // post
        $post = DB::table('posts')
            ->where('slug', $slug)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {

            //update count view post
            if(!request()->session()->has('posts-'.$post->id)) {
                DB::table('posts')->whereId($post->id)->increment('view');
                request()->session()->put('posts-'.$post->id, 1);
            }

            $post->patterns = CommonMethod::replaceText($post->patterns);
            $post->summary = CommonMethod::replaceText($post->summary);
            $post->description = CommonMethod::replaceText($post->description);

            // auto meta post for seo
            // $postName = ucwords(mb_strtolower($post->name));
            $postName = mb_convert_case($post->name, MB_CASE_TITLE, "UTF-8");
            $post->h1 = $postName;
            $postNameNoLatin = CommonMethod::convert_string_vi_to_en($postName);
            if(empty($post->meta_title)) {
                $post->meta_title = 'Xem anime '.$postName;
            }
            if(empty($post->meta_keyword)) {
                $post->meta_keyword = 'Xem anime '.$postName.', xem anime '.$postNameNoLatin;
            }
            if(empty($post->meta_description)) {
                $post->meta_description = CommonMethod::limit_text(strip_tags($post->description), 200);
            }
            if(empty($post->meta_image)) {
                $post->meta_image = '/img/img600x315.jpg';
            }

            // nation
            $post->nationName = CommonOption::getNation($post->nation);

            if($post->season != '' && $post->year > 0) {
                // season + year
                $post->seasonYearName = CommonOption::getSeason($post->season) . ' năm ' . $post->year;
            }

            // seri
            $seri = DB::table('post_series')
                    ->select('id', 'name', 'slug')
                    ->where('id', $post->seri)
                    ->where('status', ACTIVE)
                    ->first();
            if(isset($seri)) {
                $post->seriInfo = $seri;
                // seri data: danh sach thuoc seri nay
                $post->seriData = $this->getPostBySeriQuery($post->seri, $post->id)->get();
            }

            // list tags
            $tags = $this->getRelationsByPostQuery('tag', $post->id);
            $post->tags = $tags;

            // list type
            $types = $this->getRelationsByPostQuery('type', $post->id);
            $post->types = $types;

            // epchap list
            $eps = $this->getEpchapListByPostId($post->id, 'asc')->take(PAGINATE_BOX)->get();
            // $post->eps = $eps;

            // epchap list latest
            $epsLastest = $this->getEpchapListByPostId($post->id, 'desc')->take(PAGINATE_RELATED)->get();
            $post->epsLastest = $epsLastest;

            // list post by type 
            // $related = $this->getPostRelated($post->id, [$post->id], $post->type_main_id);

            // first & last epchap
            // $epFirst = $this->getEpchapListByPostId($post->id, 'asc')->first();
            if(!empty($eps)) {
                $post->epFirst = $eps[0];
            }
            // $epLast = $this->getEpchapListByPostId($post->id, 'desc')->first();
            if(!empty($epsLastest)) {
                $post->epLast = $epsLastest[0];
            }

            $countEps = $this->countEpchapListByPostId($post->id);
            $totalPageEps = ceil($countEps / PAGINATE_BOX);
            $currentPageEps = 1;
            $listPageEps = null;
            if($totalPageEps > 0) {
                for($i = 1; $i <= $totalPageEps; $i++) {
                    $listPageEps[$i] = 'Trang ' . $i;
                }
            }
            $post->countEps = $countEps;
            $post->totalPageEps = $totalPageEps;
            $post->currentPageEps = $currentPageEps;
            $post->listPageEps = $listPageEps;
            $post->prevPageEps = ($currentPageEps > 1)?($currentPageEps - 1):null;
            $post->nextPageEps = ($currentPageEps < $totalPageEps)?($currentPageEps + 1):null;

            // return view
            return view('site.post.book', ['post' => $post]);
        }
        return response()->view('errors.404', [], 404);
    }
    public function page2($slug1, $slug2)
    {
        // query
        // post
        $post = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2')
            ->where('slug', $slug1)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {
            // current epchap
            $data = DB::table('post_eps')
                ->where('slug', $slug2)
                ->where('post_id', $post->id)
                ->where('status', ACTIVE)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->first();
            if(isset($data)) {

                //update count view post
                if(!request()->session()->has('posts-'.$post->id.'-'.$data->id)) {
                    DB::table('posts')->whereId($post->id)->increment('view');
                    request()->session()->put('posts-'.$post->id.'-'.$data->id, 1);
                }

                // auto meta post for seo
                // $postName = ucwords(mb_strtolower($post->name));
                $postName = mb_convert_case($post->name, MB_CASE_TITLE, "UTF-8");
                $data->h1 = $postName . ' - ' . $data->name;
                if(empty($data->meta_title)) {
                    $data->meta_title = $postName.' - '.$data->name;
                }
                if(empty($data->meta_keyword)) {
                    $data->meta_keyword = $postName.' - '.$data->name;
                }
                if(empty($data->meta_description)) {
                    $data->meta_description = CommonMethod::limit_text(strip_tags($data->description), 200);
                }
                if(empty($data->meta_image)) {
                    $data->meta_image = '/img/img600x315.jpg';
                }

                // list type
                $types = $this->getRelationsByPostQuery('type', $post->id);
                $post->types = $types;

                // epchap list
                $eps = $this->getEpchapListByPostId($post->id, 'asc')->get();

                // SELECT BOX EPCHAP
                $epchapArray = array();
                foreach($eps as $key => $value) {
                    $epchapUrl = url($post->slug . '/' . $value->slug);
                    $epchapArray[$epchapUrl] = 'Tập ' . $value->epchap;
                }
                $post->epchapArray = $epchapArray;

                // PREV & NEXT EPCHAP
                // epchap dua vao position (bat buoc phai nhap dung position)
                $epPrev = $this->getEpchapListByPostId($post->id, 'desc')->where('position', '<', $data->position)->first();
                $epNext = $this->getEpchapListByPostId($post->id, 'asc')->where('position', '>', $data->position)->first();
                
                // gan gia tri vao $data
                if(isset($epPrev)) {
                    $data->epPrev = $epPrev;
                }
                if(isset($epNext)) {
                    $data->epNext = $epNext;
                }
                // END PREV & NEXT EPCHAP

                // server
                $serverArray = [];
                if(!empty($data->server0)) {
                    $serverArray[$data->server0] = 'Fast';
                }
                if(!empty($data->server1)) {
                    $serverArray[$data->server1] = 'Server 1';
                }
                if(!empty($data->server2)) {
                    $serverArray[$data->server2] = 'Server 2';
                }
                if(!empty($data->server3)) {
                    $serverArray[$data->server3] = 'Server 3';
                }
                if(!empty($data->server4)) {
                    $serverArray[$data->server4] = 'Server 4';
                }
                if(!empty($data->server5)) {
                    $serverArray[$data->server5] = 'Server 5';
                }
                $data->serverArray = $serverArray;


                // return view
                return response()->view('site.post.epchap', [
                        'post' => $post, 
                        'data' => $data, 
                    ]);
            }
        }
        return response()->view('errors.404', [], 404);
    }
    public function search(Request $request)
    {
        trimRequest($request);

        // check page
        $page = ($request->page)?$request->page:1;

        // auto meta tag for seo
        $seo = new \stdClass();
        $seo->h1 = 'Kết quả tìm kiếm ' . $request->s;
        if($page > 1) {
            $seo->meta_title = 'Kết quả tìm kiếm ' . $request->s . ' trang ' . $page;
        } else {
            $seo->meta_title = 'Kết quả tìm kiếm ' . $request->s;
        }
        $seo->meta_keyword = 'tìm anime ' . $request->s . ', tim anime ' . $request->s;
        $seo->meta_description = 'Kết quả tìm kiếm từ khóa ' . $request->s . ', tìm anime ' . $request->s;
        $seo->meta_image = '/img/img600x315.jpg';

        if($request->s == '' || strlen($request->s) < 2 || strlen($request->s) > 255) {
            return view('site.post.search', ['data' => null, 'seo' => $seo, 'request' => $request]);
        }
        
        // query
        // post
        $data = $this->searchQueryPostTag($request->s)->paginate(PAGINATE);

        $authors = $this->getTagsByPosts($data);

        // return view
        return view('site.post.search', ['data' => $data->appends($request->except('page')), 'seo' => $seo, 'authors' => $authors, 'request' => $request]);
    }
    public function livesearch(Request $request)
    {
        trimRequest($request);

        if($request->s == '' || strlen($request->s) < 2 || strlen($request->s) > 255) {
            return null;
        }
        
        $array = array();
        // AJAX SEARCH
        // Search theo ten post va ten tac gia
        $data = $this->searchQueryPostTag($request->s)->take(PAGINATE_RELATED)->get();

        if(!empty($data)) {
            foreach($data as $value) {
                // neu search theo ten post & ten tac gia thi them authors!
                $authors = '';
                // list tags
                $tags = $this->getRelationsByPostQuery('tag', $value->id);
                if(!empty($tags)) {
                    foreach($tags as $k => $v) {
                        if($k > 0) {
                            $authors .= ' - ';
                        }
                        $authors .= $v->name;
                    }
                }
                $array[] = [
                    'suggestion' => $value->name.'<br>'.'<small>Hãng phim: '.$authors.'</small>',
                    'url' => url($value->slug),
                    // "attr" => [["class" => "suggestion"]]
                ];
            }
        }

        $res = ['results' => $array];
        
        return response()->json($res);
    }
    public function sitemap()
    {
        $sitemaps = array();
        foreach (glob('*.xml.gz') as $filename) {
            array_push($sitemaps, url($filename));
        }
        // return view
        $content = view('site.sitemap', ['sitemaps' => $sitemaps]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }
    // asuna: lay tat ca du lieu post (null) / hay chi lay danh sach id cua post (not null)
    private function getPostRelated($id, $ids, $typeId, $asuna = null)
    {
        // lay danh sach posts
        if($asuna == null) {
            // post moi hon
            $post1Query = $this->getPostTypeQuery($id, $ids, $typeId);
            $post1 = $post1Query->get();
            // post cu hon
            $post2Query = $this->getPostTypeQuery($id, $ids, $typeId, 1);
            $post2 = $post2Query->get();
            $posts = array_merge($post1, $post2);
            return $posts;
        }
        // lay danh sach id posts
        else {
            // post moi hon
            $post1Query = $this->getPostTypeQuery($id, $ids, $typeId);
            $post1 = $post1Query->pluck('id');
            // post cu hon
            $post2Query = $this->getPostTypeQuery($id, $ids, $typeId, 1);
            $post2 = $post2Query->pluck('id');
            $posts = array_merge($post1, $post2);
            return $posts;
        }
    }
    // lay ra post cu hon (time not null) va moi hon (time null) theo id
    // id: id post hien tai
    // typeId: id type main / related cua post hien tai. ids: danh sach id da lay ra (tranh trung lap)
    private function getPostTypeQuery($id, $ids, $typeId, $time = null)
    {
        $data = DB::table('posts')
            ->join('post_type_relations', 'posts.id', '=', 'post_type_relations.post_id')
            ->select('posts.id', 'posts.name', 'posts.slug',  'posts.name2', 'posts.image', 'posts.type', 'posts.kind', 'posts.view', 'posts.year', 'posts.episode')
            ->where('posts.status', ACTIVE)
            ->where('posts.start_date', '<=', date('Y-m-d H:i:s'));
        if($time == null) {
            $data = $data->where('posts.id', '>', $id);
        } else {
            $data = $data->where('posts.id', '<', $id);
        }
        $data = $data->where('post_type_relations.type_id', $typeId)
            ->whereNotIn('post_type_relations.post_id', $ids)
            ->orderBy('posts.id', 'desc')
            ->take(PAGINATE_RELATED);
        return $data;
    }
    // get post by seri field in posts table
    private function getPostBySeriQuery($id, $currentPostId = null)
    {
        $data = DB::table('posts')
            ->select('id', 'name', 'slug', 'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('seri', $id)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'));
        if($currentPostId != null) {
            $data = $data->where('id', '!=', $currentPostId);
        }
        return $data;
    }
    // element: tag or type / id: id of tag or type
    private function getPostByRelationsQuery($element, $id)
    {
        $data = DB::table('posts')
            ->join('post_'.$element.'_relations', 'posts.id', '=', 'post_'.$element.'_relations.post_id')
            ->select('posts.id', 'posts.name', 'posts.slug',  'posts.name2', 'posts.image', 'posts.type', 'posts.kind', 'posts.view', 'posts.year', 'posts.episode')
            ->where('post_'.$element.'_relations.'.$element.'_id', $id)
            ->where('posts.status', ACTIVE)
            ->where('posts.start_date', '<=', date('Y-m-d H:i:s'));
        return $data;
    }
    // element: tag or type / id: id of post
    private function getRelationsByPostQuery($element, $id)
    {
        $data = DB::table('post_'.$element.'s')
            ->join('post_'.$element.'_relations', 'post_'.$element.'s.id', '=', 'post_'.$element.'_relations.'.$element.'_id')
            ->select('post_'.$element.'s.id', 'post_'.$element.'s.name', 'post_'.$element.'s.slug')
            ->where('post_'.$element.'_relations.post_id', $id)
            ->where('post_'.$element.'s.status', ACTIVE)
            ->get();
        return $data;
    }
    // list posts
    private function getPosts($orderBy = 'start_date', $orderSort = 'desc')
    {
        $data = DB::table('posts')
            ->select('id', 'name', 'slug',  'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy($orderBy, $orderSort);
        return $data;
    }
    // $id: $post_id
    private function getEpchapListByPostId($id, $orderSort = 'desc')
    {
        $data = DB::table('post_eps')
                ->select('id', 'name', 'slug', 'epchap', 'start_date')
                ->where('post_id', $id)
                ->where('status', ACTIVE)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->orderByRaw(DB::raw("position = '0', position ".$orderSort));
        return $data;
    }
    private function countEpchapListByPostId($id)
    {
        $data = DB::table('post_eps')
                ->where('post_id', $id)
                ->where('status', ACTIVE)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->count();
        return $data;
    }
    // search query
    // to full text search (mysql) working
    // my.ini (my.cnf) add after line [mysqld] before restart sql service: 
    // innodb_ft_min_token_size = 2
    // ft_min_word_len = 2
    // run: mysql> REPAIR TABLE tbl_name QUICK;
    // UNION 2 SELECT with paginate:
    // https://stackoverflow.com/questions/25338456/laravel-union-paginate-at-the-same-time
    private function searchQueryPostTag($s)
    {
        // addslashes: xu ly chuoi gay loi cau lenh sql. 
        $s = '+'. str_replace(' ', ' +', addslashes(trim($s)));
        $data = DB::table('posts')
            ->leftJoin('post_tag_relations', 'posts.id', '=', 'post_tag_relations.post_id')
            ->leftJoin('post_tags', 'post_tag_relations.tag_id', '=', 'post_tags.id')
            ->select('posts.id', 'posts.name AS name', 'posts.slug AS slug',  'posts.name2 AS name2', 'posts.image', 'posts.type', 'posts.kind', 'posts.view', 'posts.year', 'posts.episode')
            ->where('posts.status', ACTIVE)
            ->where('posts.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereRaw('MATCH('.env('DB_PREFIX').'posts.slug,'.env('DB_PREFIX').'posts.name,'.env('DB_PREFIX').'posts.name2) AGAINST ("'.$s.'" IN BOOLEAN MODE)')
            ->orWhereRaw('MATCH('.env('DB_PREFIX').'post_tags.slug,'.env('DB_PREFIX').'post_tags.name) AGAINST ("'.$s.'" IN BOOLEAN MODE)')
            ->groupBy('posts.id');
        return $data;
    }
    // $data post
    private function getTagsByPosts($data)
    {
        $authors = array();
        if(!empty($data)) {
            foreach($data as $value) {
                $author = '';
                // list tags
                $tags = $this->getRelationsByPostQuery('tag', $value->id);
                if(!empty($tags)) {
                    foreach($tags as $k => $v) {
                        if($k > 0) {
                            $author .= ' - ';
                        }
                        $author .= '<a href="'.url('tag/'.$v->slug).'" title="'.$v->name.'">'.$v->name.'</a>';
                    }
                }
                $authors[] = $author;
            }
        }
        return $authors;
    }
    /* 
    * contact
    */
    public function contact(Request $request)
    {
        CommonMethod::forgetCache('/lien-he');
        CommonMethod::forgetCache('/contact');
        
        //
        $now = strtotime(date('Y-m-d H:i:s'));
        $range = 300; //second
        $time = $now - $range;
        $past = date('Y-m-d H:i:s', $time);
        // check ip with time
        $checkIP = DB::table('contacts')->where('ip', $request->ip())->where('created_at', '>', $past)->count();
        if($checkIP > 0) {
            return redirect()->back()->with('warning', 'Hệ thống đang bận. Xin bạn hãy thử lại sau ít phút.');
        }
        //
        trimRequest($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'tel' => 'max:255',
            'msg' => 'max:1000',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'tel' => $request->tel,
                'msg' => $request->msg,
                'ip' => $request->ip()
            ]);
        return redirect()->back()->with('success', 'Cảm ơn bạn đã gửi thông tin liên hệ cho chúng tôi.');
    }
    public function errorreporting(Request $request)
    {
        $now = strtotime(date('Y-m-d H:i:s'));
        $range = 600; //second
        $time = $now - $range;
        $past = date('Y-m-d H:i:s', $time);
        // check ip with time
        $checkIP = DB::table('contacts')->where('ip', $request->ip())->where('created_at', '>', $past)->count();
        if($checkIP > 0) {
            return response()->json(['message' => 'Created!'], 201);
        }
        //
        trimRequest($request);
        Contact::create([
                'name' => 'Báo lỗi',
                'msg' => $request->url,
                'ip' => $request->ip()
            ]);
        return response()->json(['message' => 'Accepted!'], 202);
    }
    public function bookpaging(Request $request)
    {
        trimRequest($request);
        // check page
        $page = ($request->page)?$request->page:1;
        $id = ($request->id)?$request->id:0;

        // query
        // post
        $post = DB::table('posts')
            ->where('id', $id)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {
            $countEps = $this->countEpchapListByPostId($post->id);
            $totalPageEps = ceil($countEps / PAGINATE_BOX);
            $currentPageEps = ($page > 0 && $page <= $totalPageEps)?$page:1;
            $listPageEps = null;
            if($totalPageEps > 0) {
                for($i = 1; $i <= $totalPageEps; $i++) {
                    $listPageEps[$i] = 'Trang ' . $i;
                }
            }
            $post->countEps = $countEps;
            $post->totalPageEps = $totalPageEps;
            $post->currentPageEps = $currentPageEps;
            $post->listPageEps = $listPageEps;
            $post->prevPageEps = ($currentPageEps > 1)?($currentPageEps - 1):null;
            $post->nextPageEps = ($currentPageEps < $totalPageEps)?($currentPageEps + 1):null;

            // offset
            $offset = ($page - 1) * PAGINATE_BOX;

            // epchap list
            $eps = $this->getEpchapListByPostId($post->id, 'asc')->skip($offset)->take(PAGINATE_BOX)->get();
            $post->eps = $eps;

            // return view
            return view('site.post.booklist', ['post' => $post]);
        }
        return '<p>Đang cập nhật</p>';
    }

    public function rating(Request $request)
    {
        trimRequest($request);

        $rating = ($request->rating)?$request->rating:1;
        $id = ($request->id)?$request->id:0;

        $res = [];
        
        $ratingCookieName = 'rating' . $id;
        if(isset($_COOKIE[$ratingCookieName])) {
            return response()->json($res);
        }

        // post
        $post = DB::table('posts')
            ->where('id', $id)
            ->where('status', ACTIVE)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {
            if($post->rating_value == 0) {
                $ratingValue = $rating;
            } else {
                $ratingValue = ($post->rating_value + $rating) / 2;
            }
            $ratingValue = round($ratingValue, 1, PHP_ROUND_HALF_UP);
            $ratingCount = $post->rating_count + 1;
            DB::table('posts')->where('id', $id)->update(['rating_value' => $ratingValue, 'rating_count' => $ratingCount]);
            $res = ['ratingValue' => $ratingValue, 'ratingCount' => $ratingCount];
        }
        return response()->json($res);
    }
    
}
