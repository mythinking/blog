<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-10
 * Time: 下午9:40
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class Administrator {
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function handle($request,Closure $next){
        //超级管理员权限
        if($this->auth->check() && Auth::user()->level >= 99){
            return $next($request);
        }
        return new RedirectResponse(url('home'));
    }
}