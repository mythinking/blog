<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-10
 * Time: 下午9:53
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Contributor {

    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function handle($request,Closure $next){
        //投稿人权限
        if($this->auth->check() && Auth::user()->level >= 9){
            return $next($request);
        }else{
            return new RedirectResponse(url('home'));
        }

    }
}