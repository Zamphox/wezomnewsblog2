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

Route::group(['middleware'=>'web'], function() {
	Route::get('/', ['as'=>'home','uses'=>'IndexController@show']);
	Route::get('/about',['as'=>'about', 'uses'=>'AboutController@show']);
	Route::get('/contact',['as'=>'contact','uses'=>'ContactController@show']);
	Route::post('/contact',['uses'=>'ContactController@mail']);
	Route::get('/tags',['as'=>'tags','uses'=>'TagsController@show']);
	Route::get('/category/{category}',['as'=>'category','uses'=>'TagController@showCategory']);
	Route::get('/storage/images/{filename}',['as'=>'show_image','uses'=>'AdminController@show_image']);
	Route::get('/article/{id}/{name}',['as'=>'article', 'uses'=>'ArticleController@show']);
	Route::get('/tag/{tag}',['as'=>'tag','uses'=>'TagController@showTag']);

	Route::auth();
	Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
	Route::get('/tags',['as'=>'tags','uses'=>'TagController@showTags']);

});

Route::group(['middleware'=>'auth'], function() {
	Route::post('/article/{id}/{name}',['as'=>'comment', 'uses'=>'CommentsController@create']);


});

Route::group(['middleware'=>['auth','admin']], function() {
	Route::get('/admin',['as'=>'admin','uses'=>'AdminController@show']);
	Route::post('/admin',['as'=>'admin_post','uses'=>'AdminController@create']);
	Route::get('/article/{id}/{name}/edit',['as'=>'article_edit', 'uses'=>'AdminController@show_edit']);
	Route::post('/article/{id}/{name}/edit',['uses'=>'AdminController@edit']);
	Route::get('/article/{id}/{name}/delete',['as'=>'article_delete', 'uses'=>'AdminController@delete']);
	Route::get('/article/delete/comment/{id}',['as'=>'drop_comment','uses'=>'CommentsController@delete']);
	Route::get('/article/edit/comment/{id}',['as'=>'edit_comment','uses'=>'CommentsController@show_edit']);
	Route::post('/article/edit/comment/{id}',['uses'=>'CommentsController@edit']);
});