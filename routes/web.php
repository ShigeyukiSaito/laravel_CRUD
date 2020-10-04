<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', 'UserController@Logout');

Route::get('/signin', function () {
    return view('login');//React UI のAuthとかぶらないように、uri名変えた
});

Route::get('/signup', function () {
    return view('signup');
});

//Route::get('/user', 'Auth\LoginController@handleGoogleCallback')->name('user');
Route::get('/user', 'UserController@show')->name('user');
//Route::resource('user', 'UserController', ['only' => ['index', 'show']]);
Route::post('/user', 'UserController@create')->name('userCreate'); 

//ユーザ登録からのユーザページと、ログインからのユーザページで、URIを変えた。
/*Route::get('/user/home', function() {
    return view('user');
});*/
Route::get('/user/home', 'UserController@show');
Route::post('/user/home', 'UserController@GoogleLogin')->name('googleLoginAuth'); 
//Route::match(['get', 'post'], '/user/home', 'UserController@show')->name('userLoginAuth');
Route::put('/user/home', 'UserController@update');

Route::get('/user/home/edit', function() {
    return view('edit_profile');
});

//退会処理
Route::get('/user/unsubscribe', 'UserController@delete') ;

Route::get('/user/1', function() {
    return view('user');
});
Route::post('/user/1', 'UserController@show')->name('userLoginAuth'); 
//Route::match(['get', 'post'], '/user/1', 'UserController@GoogleLogin');



Route::get('/password_reset', function () {
    return view('password_reset');
});


//react 導入して--authやったら、下記が追加された。
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Googleのjavascriptによるログインではない↓
//Googleへのリダイレクト
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
//Googleから本アプリへ戻ってくる
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
