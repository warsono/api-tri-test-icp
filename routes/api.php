<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//login / register
Route::post('users/login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

Route::group(['middleware' => 'auth:api'], function(){
//Post
Route::get('posts', 'PostsController@index');       // Get Post List
Route::post('posts/add', 'API\PassportController@createPost');  //Insert Post
Route::put('/posts/{id}/edit', 'API\PassportController@UpdatePost');    //edit Post by Id
Route::get('posts/{id}', 'PostsController@getPostDetails');           //Post Detail by id

});