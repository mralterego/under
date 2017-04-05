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

Auth::routes();

Route::get('/home', 'HomeController@index');
