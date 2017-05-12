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

    Route::get('/work', ['as' => 'parser.test', 'uses' => 'Admin\ParserController@parseAndSave']);

    Route::get('/api', ['as' => 'parser.api', 'uses' => 'Admin\ParserController@api']);

    Route::post('/create', ['as' => 'parser.create', 'uses' => 'Admin\ParserController@create']);

    Route::get('/test/dot', ['as' => 'parser.test.dot', 'uses' => 'Admin\ParserController@testDot']);

    Route::get('/test/psytribe', ['as' => 'parser.test.psytribe', 'uses' => 'Admin\ParserController@testPsyTribe']);

    Route::get('/test/gribych', ['as' => 'parser.test.gribych', 'uses' => 'Admin\ParserController@testGribych']);

    Route::get('/test/test', ['as' => 'parser.test.test', 'uses' => 'Admin\ParserController@testTest']);


});




Auth::routes();

Route::get('/home', 'HomeController@index');
