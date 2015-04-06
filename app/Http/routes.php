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
*/

Route::get('/', 'HomeController@index');

Route::get('home', 'HomeController@index');
Route::get('category/date/{date}','Post\CategoryController@date');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('post/{id}','Post\PostController@show')->where('id','[0-9]+');
Route::get('post/create',['middleware' => 'contributor','uses' => 'Post\PostController@create']);
Route::post('post/store',['middleware' => 'contributor','uses' => 'Post\PostController@store']);

//Route::get('manage',['middleware' => 'administrator','uses' => 'Manage\ManageController@index']);
Route::get('manage',['middleware' => 'administrator','uses' => 'Post\PostController@index']);

Route::get('manage/setting',['middleware' => 'administrator','uses' => 'Manage\SettingController@lists']);

Route::get('manage/posts',['middleware' => 'administrator','uses' => 'Post\PostController@index']);
Route::get('manage/posts/delete',['middleware' => 'administrator','uses' => 'Post\PostController@destroy']);
Route::get('manage/posts/edit',['middleware' => 'administrator','uses' => 'Post\PostController@edit']);
Route::post('manage/posts/update',['middleware' => 'administrator','uses' => 'Post\PostController@update']);

Route::get('manage/user',['middleware' => 'administrator','uses' => 'Manage\UserController@lists']);
