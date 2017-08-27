<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Crypt;
use DB;
use Cache;

class CachingMiddleware
{
    /**
     * @var int
     */
    protected $lifeTime = 1;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Cookie
     */
    protected $cookie;


    /**
    * @var array
    */
    protected $replaceData = [
        '%%csrf_token%%' => [
            'type' => 'string',
            'data' => '',
        ],
        '<!--history-->' => [
            'type' => 'view',
            'data' => 'site.common.history',
        ]
    ];

    protected function getResponse(Closure $next) {
        // check if we don't need to cache
        if (!$this->isCached()) return $next($this->request);

        // $cacheName = $this->request->getPathInfo(); // no query string
        // $cacheName = $this->request->fullUrl(); // full url
        $cacheName = $this->request->getRequestUri(); // with query string

        // bookpaging co phan trang nen cache khac 1 chut
        // pramas: id va page
        // if($cacheName == '/bookpaging') {
        //     $params = $this->request->all();
        //     $cacheName .= '_' . $params['id'] . '_' . $params['page'];
        // }

        if(getDevice2() == MOBILE) {
            $cacheName = $cacheName.'_mobile';
        }

        if(!Cache::has($cacheName)) {
            $response = $next($this->request);

            $response->original = '';

            // Cache::put($cacheName, $response, $this->lifeTime);

            Cache::forever($cacheName, $response);

            return $response;
        } else {
            return Cache::get($cacheName);
        }
    }

    protected function isCached() {
        if(app()->environment('local')) return false;
        
        if(CACHE == 2) return false;

        $cacheRoute = collect();
        // allow controller & deny actions (in routes)
        $cacheRoute->put('App\Http\Controllers\Site\SiteController', collect(['errorreporting','rating','contact']));

        list($controller, $action) = explode('@', $this->request->route()->getActionName());

        $checkController = $cacheRoute->get($controller, false);

        // If current controller not in $cacheRoute collect return false (no cache)
        if($checkController === false) return false;

        // If current controller in $cacheRoute but collect empty return true (cache)
        if($checkController->isEmpty()) return true;

        // If current controller in $cacheRoute & collect has item. check $action in or not in collect.
        // If current action in collect, return false (no cache) or return true (cache).
        if($checkController->search($action) !== false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @var string $content
     * @var string $placeholder
     * @var array $replace
     * @return string
     */
    protected function replaceViewContent($content, $placeholder, $replace) {
        $replace = $this->historyFromCookie();
        return str_replace($placeholder, $replace, $content);
    }

    /**
     * @var string $content
     * @var string $placeholder
     * @var array $replace
     * @return string
     */
    protected function replaceStringContent($content, $placeholder, $replace) {
        $csrf_token = $this->request->session()->token();
        if(isset($csrf_token)) {
            return str_replace($placeholder, $csrf_token, $content);
        } else {
            return str_replace($placeholder, csrf_token(), $content);
        }
        // return str_replace($placeholder, $replace['data'], $content);
    }

    /**
     * @param string $content
     * @return string
     */
    protected function replaceDynamicContent($content) {
        foreach($this->replaceData as $placeholder => $replace) {
            $method = 'replace' . ucfirst($replace['type']) . 'Content';
            $content = method_exists($this, $method) ?
                $this->{$method}($content, $placeholder, $replace) :
                $content;
        }
        // minify response html
        $content = $this->optimizeHtml($content);
        return $content;
    }

    public function handle(Request $request, Closure $next) {
        $this->request = $request;

        $this->cookie = $this->request->cookie(COOKIE_NAME);

        $response = $this->getResponse($next);

        $response = $response->setContent($this->replaceDynamicContent($response->content()));

        if($this->request->route()->getActionName() == 'App\Http\Controllers\Site\SiteController@page2') {
            // set cookie epchap reading, hien tai chi luu 1 record vao cookie
            $cookie = cookie()->forever(COOKIE_NAME, $this->request->getPathInfo());

            return $response->withCookie($cookie);
        }

        return $response;
    }

    private function optimizeHtml($content)
    {
        // if site then minify
        preg_match('/([a-z]*)@/i', $this->request->route()->getActionName(), $matches);
        $controllerName = $matches[1];
        if($controllerName == 'SiteController') {
            if(strpos($content,'<pre>') !== false)
            {
                $replace = array(
                    // '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    '/<!--[^\[](.*?)[^\]]-->(<!--history-->)/s' => '',
                    "/<\?php/"                  => '<?php ',
                    "/\r/"                      => '',
                    "/>\n</"                    => '><',
                    "/>\s+\n</"                 => '><',
                    "/>\n\s+</"                 => '><',
                    "/>\s</"                    => '><',
                );
            } else {
                $replace = array(
                    // '/<!--[^\[](.*?)[^\]]-->/s' => '',
                    '/<!--[^\[](.*?)[^\]]-->(<!--history-->)/s' => '',
                    "/<\?php/"                  => '<?php ',
                    "/\n([\S])/"                => '$1',
                    "/\r/"                      => '',
                    "/\n/"                      => '',
                    "/\t/"                      => '',
                    "/ +/"                      => ' ',
                    "/>\s</"                    => '><',
                );
            }
            $content = preg_replace(array_keys($replace), array_values($replace), $content);
            ini_set('zlib.output_compression', 'On'); // If you like to enable GZip, too!
        }
        return $content;
    }

    private function historyFromCookie() {
        $cookie = $this->cookie;
        if(!empty($cookie)) {
            $cookieArray = explode('/', $cookie);
            if(!empty($cookieArray)) {
                if(CACHE == 1) {
                    // cache name
                    $cacheName = 'history_'.$cookie;
                    // get cache
                    if(Cache::has($cacheName)) {
                        return Cache::get($cacheName);
                    }
                }
                // query
                // post
                $post = DB::table('posts')
                    ->select('id', 'name', 'slug',  'name2', 'image', 'type', 'kind', 'view', 'year', 'episode')
                    ->where('slug', $cookieArray[1])
                    ->where('status', ACTIVE)
                    ->where('start_date', '<=', date('Y-m-d H:i:s'))
                    ->first();
                if(isset($post)) {
                    // current epchap
                    $data = DB::table('post_eps')
                        ->select('id', 'name', 'slug', 'epchap')
                        ->where('slug', $cookieArray[2])
                        ->where('post_id', $post->id)
                        ->where('status', ACTIVE)
                        ->where('start_date', '<=', date('Y-m-d H:i:s'))
                        ->first();
                    if(isset($data)) {
                        if(CACHE == 1) {
                            // put cache
                            $html = view('site.common.history', ['data' => $data, 'post' => $post])->render();
                            // Cache::put($cacheName, $html, $this->lifeTime);
                            Cache::forever($cacheName, $html);
                        }
                        // return view
                        return view('site.common.history', ['data' => $data, 'post' => $post])->render();
                    }
                }
            }
        }
        return '<!--history-->';
    }

}
