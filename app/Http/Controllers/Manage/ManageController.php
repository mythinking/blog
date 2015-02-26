<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-8
 * Time: 下午11:13
 */

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;

/**
 * 后台管理总控制
 * @author wenxufeng
 * @version 1.0
 * @package App\Http\Controllers\Manage
 */
class ManageController extends Controller {
    public function index(){
        return view('manage/index');
    }

    public function setting(){
        return view('manage/setting');
    }

    public function posts(){
        return view('manage/posts');
    }
}