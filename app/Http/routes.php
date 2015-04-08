<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| 参数规则定义在 \App\Providers\RouteServiceProvider.php\boot
*/

Route::get('/{page?}/{limit?}', 'HomeController@index');
Route::get('home/{page?}/{limit?}', 'HomeController@index');

//article归档分类
Route::group(['prefix' => 'archive','namespace' => 'Post'],function(){
    Route::get('/date/{date}/{page?}/{limit?}','ArchiveController@date');
    Route::get('/tags/{id}/{page?}/{limit?}','ArchiveController@tags');
});

//用户登录认证相关
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//article操作
Route::group(['prefix' => 'post','namespace' => 'Post'],function(){
    Route::get('/{id}','PostController@show');             //展示

    Route::group(['middleware' => 'contributor'],function(){    //创建，需要撰稿人才可以操作
        Route::get('/create','PostController@create');
        Route::post('/store','PostController@store');
    });
});


//后台操作，必须是管理员才可以操作
Route::group(['middleware' => 'administrator','prefix' => 'manage'],function(){
    Route::get('/', 'Post\PostController@index');                       //后台首页

    Route::group(['prefix' => 'setting','namespace' => 'Manage'],function(){                    //设置操作
        Route::get('/', 'SettingController@lists');
    });

    Route::group(['prefix' => 'posts','namespace' => 'Post'],function(){                      //文章操作，增删改查
        Route::get('/{page?}/{limit?}', 'PostController@index');
        Route::get('/edit/{id}', 'PostController@edit');
        Route::get('/delete', 'PostController@destroy');
        Route::post('/update', 'PostController@update');
    });

    Route::group(['prefix' => 'user','namespace' => 'Manage'],function(){                       //用户管理
        Route::get('/', 'UserController@lists');
    });
});