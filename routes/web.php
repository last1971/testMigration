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
App::setLocale('ru');
Route::get('/', 'MainController@index');
Route::get('test', 'TestController@show')->name('test');
Auth::routes();
Route::get('home', 'HomeController@index')->name('home');
Route::get('current-user', function(){
    return Auth::user();
});
Route::resource('users', 'UserController')->middleware('check.user');
Route::resource('userTypes', 'UserTypeController');