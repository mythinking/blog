<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-8
 * Time: 下午11:13
 */

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Services\Post;
use Illuminate\Support\Facades\Input;

/**
 * 后台管理总控制
 * @author wenxufeng
 * @version 1.0
 * @package App\Http\Controllers\Manage
 */
class ManageController extends Controller {
    public function index(){
        return view('manage.index');
    }

    public function setting(){
        return view('manage.setting');
    }

    public function user(){
        return view('manage.user');
    }

    public function posts(){
        //当前页数及limit
        $page = intval(Input::get('page',1));
        $limit = Input::get('limit',10);

        $posts = Post::listAll($page,$limit);
        $count = Post::count();

        //页数
        $pageCount = ceil($count/$limit);

        //分页参数
        $pager = [
            'page' => $page,
            'count' => $pageCount,
            'prev' => ($page > 1) ? ($page - 1) : '',
            'next' => ($page < $pageCount) ? ($page + 1) : '',
        ];
        return view('manage.posts',['posts' => $posts,'pager' => $pager]);
    }
}