<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/5 0005
 * Time: 下午 11:59
 */
namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller{

    public function lists(){
        $res = User::all();
        return view('manage.user',['user' => $res]);
    }
}