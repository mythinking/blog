<?php namespace App\Http\Controllers\Post;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($page = 1,$limit = 20){

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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
        return view('post.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $postId = null;
        $input = Input::get();
        if(Post::validator($input)){
            $postId = Post::create($input);
        }
        echo $postId;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
        $post = Post::show(intval($id));
        return view('post.show',['post' => $post]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $post = Post::show(intval($id));
        $tagString = '';
        foreach($post->tags as $tag){
            $tagString .= "#".$tag;
        }
        $post->tags = $tagString;
        return view('post.create',['post' => $post]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$input = Input::get();
        $id = intval($input['postId']);

        if(Post::validator($input)){
            $res = Post::update($id,$input);
        }

        echo $res ? $id : -1;
	}

	/**
	 * Remove the specified resource from storage.
	 * @return Response
	 */
	public function destroy()
	{
        $id = intval(Input::get('id',0));
        if($id == 0)
            return ;

        echo Post::delete($id) ? 1 : -1;
	}

}
