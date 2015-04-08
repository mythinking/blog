<?php
namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Services\Post;

class ArchiveController extends Controller {

    public function date($date,$page = 1,$limit = 20){
        if(!strtotime($date)) exit;
        $data = Post::getDateArchive($date,$page,$limit);
        return $this->showArchive($data,$date,'date',$page,$limit);
    }

    public function tags($id,$page = 1,$limit = 20){
        $data = Post::getTagsArchive(intval($id),$page,$limit);
        return $this->showArchive($data,$id,'tags',$page,$limit);
    }

    public function showArchive($data,$key,$view,$page,$limit){
        $pageCount = ceil($data['count']/$limit);

        $pager = [
            'page' => $page,
            'count' => $pageCount,
            'prev' => ($page > 1) ? ($page - 1) : '',
            'next' => ($page < $pageCount) ? ($page + 1) : '',
        ];
        return view('post.archive',[
            'data' => $data['posts'],
            'view' => $view,
            'key' => $key,
            'pager' => $pager
        ]);
    }
}