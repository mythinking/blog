<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-10
 * Time: 下午10:35
 */
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class Post {

    public static function validator(array $data){
        return Validator::make($data,[
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
    }

    /**
     * @brief 添加文章
     * @param array $data
     * @return mixed
     */
    public static function create(array $data){
        //添加一篇文章insert into post;获取post_id
        //如果有标签或分类 查询是否已经有该标签或分类,有=>获取term_id,无=>insert into term; 获取term_id
        $line = array(
            'post_title' => $data['title'],
            'post_date'  => date('Y-m-d H:i:s'),
            'post_author' => Auth::user()->id,
            'post_author_name' => Auth::user()->name,
            'post_content' => $data['content'],
            'post_status' => 'publish',
            'comment_status' => isset($data['commentStatus']) && $data['commentStatus'] == 'on' ? 'open' : 'close',
            'is_page' =>  isset($data['isPage']) && $data['isPage'] == 'on' ?  1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $postId = DB::table('posts')->insertGetId($line);

        if(isset($data['tag']) && !empty($data['tag'])){
            $tags = array_filter(explode('#',$data['tag']));
            foreach($tags as $tag){
                $tagId = DB::table('terms')->where('group',1)->where('name',$tag)->pluck('term_id');
                $termId = $tagId ? $tagId : DB::table('terms')->insertGetId([
                    'group' => 1,
                    'name' => $tag,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

                //post_id与term_id 都有时 insert releationships;
                if($postId && $termId)
                    DB::table('term_relationships')->insert(['post_id' => $postId,'term_id' => $termId]);
            }
        }

        return $postId;
    }

    /**
     * @brief 获取文章详情
     * @param $id
     * @return mixed
     */
    public static function show($id){
        $postDetail = DB::table('posts')->where('post_id',intval($id))
                                        ->where('post_status','publish')
                                        ->first();
        $tagList = DB::table('term_relationships')->where('post_id',$postDetail->post_id)->join('terms','terms.term_id','=','term_relationships.term_id')
            ->lists('terms.name');
        $postDetail->tags = $tagList;
        $postDetail->post_title = trim($postDetail->post_title);
        $postDetail->post_content = trim($postDetail->post_content);
        return $postDetail;
    }
}