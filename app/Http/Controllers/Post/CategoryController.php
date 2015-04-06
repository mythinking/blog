<?php
namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Post;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller {

    public function date($date){
        if(!strtotime($date)) exit;
        $page = intval(Input::get('page',1));
        $limit = intval(Input::get('page',20));
        $data = Post::getDateCategory($date,$page,$limit);

        //页数
        $pageCount = ceil($data['count']/$limit);

        //分页参数
        $pager = [
            'page' => $page,
            'count' => $pageCount,
            'prev' => ($page > 1) ? ($page - 1) : '',
            'next' => ($page < $pageCount) ? ($page + 1) : '',
        ];
        return view('post.category',['data' => $data['posts'],'date' => $date,'pager' => $pager]);
    }
}