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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login/vk', 'Social\VkController@redirectToProvider');
Route::get('login/vk/callback', 'Social\VkController@handleProviderCallback');

Route::get('/social', function () {
    return 'success';
});

Route::group(['prefix' => '/parser'], function(){

    Route::get('/index', ['as' => 'parser.index', 'uses' => 'Admin\ParserController@index']);

    //Route::get('/work', ['as' => 'parser.test', 'uses' => 'Admin\ParserController@parse']);

    Route::get('/testdot', ['as' => 'parser.test', 'uses' => 'Admin\ParserController@testDot']);

    Route::get('/api', ['as' => 'parser.api', 'uses' => 'Admin\ParserController@api']);

    Route::post('/create', ['as' => 'parser.create', 'uses' => 'Admin\ParserController@create']);

});




Auth::routes();

Route::get('/home', 'HomeController@index');
