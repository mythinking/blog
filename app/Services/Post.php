<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

/**
 * 文章操作服务
 * @author 温旭峰
 * @version 1.0
 */
class Post {

    public static function validator(array $data){
        return Validator::make($data,[
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
    }

    /**
     * 添加文章，返回新增文章ID
     *
     * [php]
     * $data = [
     *     'title' => '文章标题',
     *     'content' => '文章内容',
     *     'commentStatus' => 'on',
     *     'isPage' => 'on',
     * ]
     * $postId = Post::create($data);
     *
     * @param array $data 文章数据
     * @return integer postId 新增文章的ID
     * @version 1.0
     */
    public static function create(array $data){
        //添加一篇文章insert into post;获取post_id
        //如果有标签或分类 查询是否已经有该标签或分类,有=>获取term_id,无=>insert into term; 获取term_id
        $line = array(
            'post_title' => $data['title'],
            'post_date'  => date('Y-m-d H:i:s'),
            'post_author' => Auth::user()->id,
            //'post_author_name' => Auth::user()->name,
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
     * @param interger $id 文章ID
     * @return mixed 文章详情
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

    public static function count(){
        return DB::table('posts')->count();
    }

    public static function listAll($page = 1,$limit = 1){
        $posts = DB::table('posts')->select('post_id','post_title','post_date','post_status','comment_count','is_page')
                                    ->orderBy('post_id','desc')
                                    ->skip(($page-1)*$limit)
                                    ->take($limit)
                                    ->get();
        $data = [];
        foreach($posts as $key => $post){
            $data[$key] = $post;
            $data[$key]->tags = DB::table('terms')->join('term_relationships',function($join)use($post){
                $join->on('term_relationships.term_id','=','terms.term_id')->where('term_relationships.post_id','=',$post->post_id);
            })->select('terms.alias','terms.name','terms.term_id','terms.group')->get();
        }
        return $data;
    }
}