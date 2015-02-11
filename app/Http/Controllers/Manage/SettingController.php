<?php
/**
 * Created by PhpStorm.
 * User: Penser
 * Date: 15-2-8
 * Time: 下午11:13
 */

namespace App\Http\Controllers\Manage;

class SettingController extends Controller {
    public function  __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('setting');
    }
}