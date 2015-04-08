<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

/**
 * 文章操作服务
 * @version 1.0
 */
class Post {

    /**
     * 验证
     * @param array $data
     * @return mixed
     */
    public static function validator(array $data){
        return Validator::make($data,[
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
    }

    /**
     * 添加文章，返回新增文章ID
     * @param array $data 文章数据
     * @return integer postId 新增文章的ID
     * @version 1.0
     */
    public static function create(array $data){
        //添加一篇文章insert into post;获取post_id
        //如果有标签或分类 查询是否已经有该标签或分类,有=>获取term_id,无=>insert into term; 获取term_id
        $line = array(
            'post_title' => trim($data['title']),
            'post_date'  => date('Y-m-d H:i:s'),
            'post_author' => Auth::user()->id,
            //'post_author_name' => Auth::user()->name,
            'post_content' => trim($data['content']),
            'post_status' => 'publish',
            'comment_status' => isset($data['commentStatus']) && $data['commentStatus'] == 'on' ? 'open' : 'close',
            'is_page' =>  isset($data['isPage']) && $data['isPage'] == 'on' ?  1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $postId = DB::table('posts')->insertGetId($line);

        if(isset($data['tag']) && !empty($data['tag'])){
            self::setTags(trim($data['tag']),$postId);
        }

        return $postId;
    }

    /**
     * 设置文章标签
     * @param $tagString
     * @param $postId
     */
    public static function setTags($tagString,$postId){
        $tags = array_filter(explode('#',$tagString));
        foreach($tags as $tag){
            $tagId = DB::table('terms')->where('group',1)->where('name',trim($tag))->pluck('term_id');
            $termId = $tagId > 0 ? $tagId : DB::table('terms')->insertGetId([
                'group' => 1,
                'name' => trim($tag),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $isset = DB::table('term_relationships')->where('post_id',$postId)->where('term_id',$termId)->pluck('post_id');
            if(!$isset)
                DB::table('term_relationships')->insert(['post_id' => $postId,'term_id' => $termId]);
        }
    }

    /**
     * 更新文章数据
     * @param $id
     * @param array $data
     * @return bool
     */
    public static function update($id,array $data){
        $line = array(
            'post_title' => trim($data['title']),
            'post_content' => trim($data['content']),
            'comment_status' => isset($data['commentStatus']) && $data['commentStatus'] == 'on' ? 'open' : 'close',
            'is_page' => isset($data['isPage']) && $data['isPage'] == 'on' ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $res = DB::table('posts')->where('post_id',$id)->update($line);

        if($res && isset($data['tag']) && !empty($data['tag'])){
            self::setTags(trim($data['tag']),$id);
            return true;
        }else{
            return false;
        }
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

    /**
     * 获取文章总数
     * @return mixed
     */
    public static function count(){
        return DB::table('posts')->count();
    }

    /**
     * 查询所有文章
     * @param int $page
     * @param int $limit
     * @return array
     */
    public static function listAll($page = 1,$limit = 1){
        $posts = DB::table('posts')->select('*')
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

    /**
     * 获取特定月份的文章归档数
     * @param $date
     * @param int $page
     * @param int $limit
     * @return array
     */
    public static function getDateArchive($date, $page = 1, $limit = 20){
        $posts = DB::table('posts')->select('post_id','post_title','post_date')
            ->whereRaw("left(post_date,7) = '{$date}'")->orderBy('post_date','desc')->skip(($page-1)*$limit)->take($limit)->get();
        $count = DB::table('posts')->whereRaw("left(post_date,7) = '{$date}'")->count();
        return ['count' => $count,'posts' => $posts];
    }

    /**
     * 获取标签分类归档
     * @param $tagId
     * @param int $page
     * @param int $limit
     * @return array
     */
    public static function getTagsArchive($tagId, $page = 1, $limit = 20){
        $posts = DB::table('posts')->join('term_relationships',function($join)use($tagId){
            $join->on('term_relationships.post_id','=','posts.post_id')->where('term_id','=',intval($tagId));
        })->select('posts.post_id','post_title','post_date')->orderBy('posts.post_id','desc')->skip(($page - 1)*$limit)->take($limit)->get();
        $count = DB::table('term_relationships')->where('term_id','=',intval($tagId))->count();
        return ['count' => $count,'posts' => $posts];
    }

    /**
     * 删除文章
     * @param $id
     * @return mixed
     */
    public static function delete($id){
        return DB::table('posts')->where('post_id','=',$id)->delete();
    }
}