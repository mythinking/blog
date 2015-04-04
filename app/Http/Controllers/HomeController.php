<?php namespace App\Http\Controllers;

use App\Services\Post;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $page = intval(Input::get('page',1));
        $limit = intval(Input::get('limit',3));

        $posts = Post::listAll($page,$limit);
        $count = Post::count();

        $pageCount = ceil($count/$limit);

        $pager = [
            'page' => $page,
            'count' => $pageCount,
            'prev' => ($page > 1) ? ($page - 1) : '',
            'next' => ($page < $pageCount) ? ($page + 1) : '',
        ];
		return view('home',['posts' => $posts,'pager' => $pager]);
	}

}
