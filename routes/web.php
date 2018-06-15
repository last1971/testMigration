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
Route::get('/', 'MainController@index'); //Глвавная
Route::get('test', 'TestController@show')->name('test');
Auth::routes(); //Авторизация
Route::get('home', 'HomeController@index')->name('home'); //Главная для прользователя
Route::get('current-user', function(){
    return Auth::user();
}); //Получить пользователя
Route::resource('users', 'UserController')->middleware('check.user');//пользователи
Route::get('userstable',function(){ return view('userstable');})->middleware('check.admin')->name('userstable');//Таблица пользователей
Route::get('articlestable', function() { return view('articlestable'); } )->middleware('check.employee')->name('articlestable');//Таблица статей
Route::resource('userTypes', 'UserTypeController');//Типы пользователей
Route::get('gitpull',function(){
    $ret = shell_exec('git pull');
    return view('gitpull',['result' => $ret]);
})->middleware('check.admin')->name('gitpull');//обновить
Route::post('load-image','ImageController@upload');//загрузка картинки
Route::resource('names', 'NameController');//Наименования
Route::resource('articles','ArticleController')->middleware('check.employee');//Статьи
Route::resource('pictures','PictureController')->middleware('check.employee');//картинки