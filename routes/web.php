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

use App\Video;


Auth::routes();

Route::get('/', array(
	'as' => 'home',
	'uses' => 'HomeController@index'
));

// Videos

Route::get('/crear-video', array(
	'as' => 'createVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@createVideo'
));

Route::post('/guardar-video', array(
	'as' => 'saveVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@saveVideo'
));

Route::get('/thumbnail/{fielanme}', array(
	'as'			=> 'imageVideo',
	'uses'			=> 'VideoController@getImage'
));

Route::get('/video/{video_id}', array(
	'as'			=> 'detailVideo',
	'uses'			=> 'VideoController@getVideoDetail'
));

Route::get('/video-file/{fielanme}', array(
	'as'			=> 'fileVideo',
	'uses'			=> 'VideoController@getVideo'
));

route::get('/delete-video/{video_id}', array(
	 'as'			=> 'videoDelete',
	 'middleware'	=> 'auth',
	 'uses'			=> 'VideoController@delete'	
));

route::get('/editar-video/{video_id}', array(
	 'as'			=> 'videoEdit',
	 'middleware'	=> 'auth',
	 'uses'			=> 'VideoController@edit'	
));

Route::post('/update-video/{video_id}', array(
	'as' => 'updateVideo',
	'middleware' => 'auth',
	'uses' => 'VideoController@update'
));

Route::get('/buscar/{search?}/{filter?}', [
	 'as'			=> 'videoSearch',
	 'uses'			=> 'VideoController@search'
]);

//Comments
Route::post('/comment', array(
	 'as'			=> 'comment',
	 'middleware'	=> 'auth',
	 'uses'			=> 'CommentController@store'
));

Route::get('/delete-comment/{comment_id}', array(
	 'as'			=> 'commentDelete',
	 'middleware'	=> 'auth',
	 'uses'			=> 'CommentController@delete'
));

// Users - Channels
Route::get('/canal/{user_id}', array(
	 'as'			=> 'channel',
	 'uses'			=> 'UserController@channel'
));

// Cache
Route::get('clear-cache', function(){
	$code = Artisan::call('cache:clear');
});


