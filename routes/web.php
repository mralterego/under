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

    Route::get('/work', ['as' => 'parser.work', 'uses' => 'Admin\ParserController@parseAndSave']);

    Route::get('/api', ['as' => 'parser.api', 'uses' => 'Admin\ParserController@api']);

    Route::get('/test/dot', ['as' => 'parser.test.dot', 'uses' => 'Admin\ParserController@testDot']);

    Route::get('/test/psytribe', ['as' => 'parser.test.psytribe', 'uses' => 'Admin\ParserController@testPsyTribe']);

    Route::get('/test/gribych', ['as' => 'parser.test.gribych', 'uses' => 'Admin\ParserController@testGribych']);

    Route::get('/test/test', ['as' => 'parser.test.test', 'uses' => 'Admin\ParserController@testTest']);

});

Route::group(['prefix' => '/admin'], function(){

    Route::get('/events/index', ['as' => 'admin.events.index', 'uses' => 'Admin\EventsController@index']);

    Route::get('/events/{id}', ['as' => 'admin.events.index', 'uses' => 'Admin\EventsController@item'])-> where('id', '[0-9]+');

    Route::get('/events/api', ['as' => 'admin.events.api', 'uses' => 'Admin\EventsController@api']);

    Route::post('/events/create', ['as' => 'admin.events.create', 'uses' => 'Admin\EventsController@create']);

    Route::post('/events/upload', ['as' => 'admin.events.upload', 'uses' => 'Admin\EventsController@upload']);

});




Auth::routes();

Route::get('/home', 'HomeController@index');
