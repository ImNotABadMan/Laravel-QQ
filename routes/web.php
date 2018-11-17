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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'user', 'namespace' => 'User'], function (){
    Route::get('test', 'UserController@test');
    Route::get('index', 'UserController@index');
    Route::get('callback/qq', 'UserController@QQCallback');
});


Route::group(['prefix' => 'email', 'namespace' => 'Email'], function (){
    Route::get('/', 'EmailController@index');
});

Route::group(['prefix' => 'imap', 'namespace' => 'Imap'], function (){
    Route::get('/{type?}', 'ImapController@index')->name('imap');
});
