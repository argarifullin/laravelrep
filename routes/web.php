<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PostController@index')->name('home');
Route::get('/article/{slug}','PostController@show')->name('post.single');
Route::get('/category/{slug}','CategoryController@show')->name('categories.single');
Route::get('/tag/{slug}','TagController@show')->name('tags.single');
Route::get('/search','SearchController@index')->name('search');
Route::post('/submitcomment', 'CommentController@submit')->name('submit')->middleware('auth');
Route::get('deletecomment/{id}_{user_id}','CommentController@delete')->name('deletecomment')->middleware('auth');

Route::group(['prefix'=> 'admin','namespace'=>'Admin','middleware'=>'admin'],function (){
Route::get('/','MainController@index')->name('admin.index');
Route::resource('/categories','CategoryController');
Route::resource('/tags','TagController');
Route::resource('/posts','PostController');
});

Route::group(['middleware'=>'guest'],function(){
  Route::get('/register','UserController@create')->name('register.create');
  Route::post('/register','UserController@store')->name('register.store');
  Route::get('/login','UserController@loginForm')->name('login.create');
  Route::post('/login','UserController@login')->name('login');
  Route::get('/restore', 'UserController@index')->name('restore.index');
  Route::post('/restore', 'UserController@restore')->name('restore.restore');
});


Route::get('/logout','UserController@logout')->name('logout')->middleware('auth');

