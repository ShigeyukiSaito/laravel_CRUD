<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/signin', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::post('/user', 'UserController@create');
Route::get('/user', function (){
    return view('user');
});

Route::get('/password_reset', function () {
    return view('password_reset');
});


//react 導入して--authやったら、下記が追加された。
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Googleへのリダイレクト
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
//Googleから本アプリへ戻ってくる
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
