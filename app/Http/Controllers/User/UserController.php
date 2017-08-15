<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\PostEp;
use App\Helpers\CommonMethod;
use App\Helpers\CommonCrawler;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $id;
    protected $name;
    protected $post_ids;

    public function __construct()
    {
        $this->id = Auth::guard('users')->user()->id;
        $this->name = Auth::guard('users')->user()->name;
        $this->post_ids = Auth::guard('users')->user()->post_ids;
    }

    public function index()
    {
        // posts
        $postIds = explode(',', $this->post_ids);
        $data = Post::select('id', 'name', 'slug',  'name2', 'image', 'type', 'kind', 'view')
                    ->whereIn('id', $postIds)
                    ->orderBy('id', 'desc')
                    ->get();
        $dataEp = [];
        if(count($data) > 0) {
            foreach($data as $value) {
                $dataEp[] = CommonCrawler::getLatestEp($value->id);
            }
        }
        return view('auth.users.index', ['data' => $data, 'dataEp' => $dataEp]);
    }

    public function account(Request $request)
    {
        trimRequest($request);
        $recaptcha = CommonMethod::recaptcha();
        if(!isset($recaptcha)) {
            redirect()->back()->with('warning', 'Xác nhận không đúng.');
        }
        $data = User::find($this->id);
        if($request->name == $data->name && $request->username == $data->username) {
        	return redirect()->back()->with('success', 'Không có thay đổi nào.');
        }
        $rules = [];
        if($request->name != $data->name) {
            $rules['name'] = 'bail|required|max:255|min:3|unique:users';
        }
        if($request->username != $data->username) {
            $rules['username'] = 'bail|required|max:255|min:3|unique:users';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $data->update([
                'name' => $request->name,
                'username' => $request->username,
            ]);
        return redirect()->back()->with('success', 'Đã cập nhật thông tin.');
    }

    public function compose()
    {
        return view('auth.users.compose');
    }

    public function composed(Request $request)
    {
        trimRequest($request);
        $recaptcha = CommonMethod::recaptcha();
        if(!isset($recaptcha)) {
            redirect()->back()->with('warning', 'Xác nhận không đúng.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|max:255|unique:posts',
            'name2' => 'max:255',
            'description' => 'max:1000',
            'type_id' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $slug = CommonMethod::convert_string_vi_to_en($request->name);
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
        $data = Post::create([
                'name' => $request->name,
                'slug' => $slug,
                'name2' => $request->name2,
                'type_main_id' => $request->type_id[0],
                'nation' => SLUG_NATION_VIETNAM,
                'description' => $request->description,
                'position' => 1,
                'start_date' => date('Y-m-d H:i:s'),
                'status' => INACTIVE,
            ]);
        if(isset($data)) {
            // find tag
            $tag = PostTag::where('user_id', $this->id)->first();
            if(isset($tag)) {
                $tag_id = [$tag->id];
            } else {
                $slugTag = CommonMethod::convert_string_vi_to_en($this->name);
                $slugTag = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slugTag));
                $dataTag = PostTag::create([
                    'name' => $this->name,
                    'slug' => $slugTag,
                    'user_id' => $this->id,
                ]);
                if(isset($dataTag)) {
                    $tag_id = [$dataTag->id];
                }
            }
            // insert post type relation
            if(isset($request->type_id)) {
                $data->posttypes()->attach($request->type_id);
            }
            // insert post tag relation
            if(isset($tag_id)) {
                $data->posttags()->attach($tag_id);
            }
            // users update post_ids
            $user = User::find($this->id);
            if(isset($user)) {
                $post_ids = $user->post_ids;
                if(!empty($post_ids)) {
                    $post_ids .= ',' . $data->id;
                } else {
                    $post_ids = $data->id;
                }
                $user->update(['post_ids' => $post_ids]);
            }
            return redirect()->route('users.write', ['x' => $data->id])->with('success', 'Truyện đã được tạo và chờ được hiển thị. Bạn có thể thêm chương mới.');
        }
        return redirect('user/compose')->with('warning', 'Quá trình xảy ra lỗi. Xin hãy thử lại.');
    }

    public function write(Request $request)
    {
        trimRequest($request);
        if(empty($request->x)) {
            return redirect('user/compose')->with('warning', 'Bạn cần thêm truyện trước khi viết.');
        }
        $data = Post::find($request->x);
        if(isset($data)) {
            $latestEp = CommonCrawler::getLatestEp($request->x);
            if(isset($latestEp)) {
                $data->currentep = $latestEp->epchap + 1;
            } else {
                $data->currentep = 1;
            }
            return view('auth.users.write', ['data' => $data]);
        }
        return redirect('user/compose')->with('warning', 'Bạn cần thêm truyện trước khi viết.');
    }

    public function wrote(Request $request)
    {
        trimRequest($request);
        $recaptcha = CommonMethod::recaptcha();
        if(!isset($recaptcha)) {
            redirect()->back()->with('warning', 'Xác nhận không đúng.');
        }
        if(empty($request->x)) {
            return redirect('user/compose')->with('warning', 'Bạn cần thêm truyện trước khi viết.');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'description' => 'required|max:10000',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // post
        $post = Post::find($request->x);
        if(!isset($post)) {
            return redirect('user/compose')->with('warning', 'Bạn cần thêm truyện trước khi viết.');
        }
        // ep
        $latestEp = CommonCrawler::getLatestEp($request->x);
        if(isset($latestEp)) {
            $epchap = $latestEp->epchap + 1;
            $ep = 'Chương ' . $epchap;
        } else {
            $epchap = 1;
            $ep = 'Chương 1';
        }
        if(!empty($request->name)) {
            $name = $ep . ': ' . $request->name;
        } else {
            $name = $ep;
        }
        // post ep
        $slug = CommonMethod::convert_string_vi_to_en($ep);
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', $slug));
        $data = PostEp::create([
                'name' => $name,
                'slug' => $slug,
                'post_id' => $request->x,
                'epchap' => $epchap,
                'description' => $request->description,
                'position' => $epchap,
                'start_date' => date('Y-m-d H:i:s'),
            ]);
        if(isset($data)) {
            if(!empty($request->kind)) {
                $postUpdate = ['start_date' => date('Y-m-d H:i:s'), 'kind' => SLUG_POST_KIND_FULL];
            } else {
                $postUpdate = ['start_date' => date('Y-m-d H:i:s')];
            }
            Post::find($request->x)->update($postUpdate);
            return redirect()->route('users.write', ['x' => $request->x])->with('success', 'Đã thêm chương. Bạn có thể thêm chương mới.');
        }
        return redirect('user/compose')->with('warning', 'Quá trình xảy ra lỗi. Xin hãy thử lại.');
    }

}
