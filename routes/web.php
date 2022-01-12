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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/profile', 'ProfileController');

Route::resource('/pertanyaan', 'PertanyaanController');

Route::resource('/jawaban', 'JawabanController');

Route::resource('/materi', 'MateriController');

Route::get('/index/all', 'PertanyaanController@showAll');

Route::get('/filePertanyaan/{file}', 'PertanyaanController@download' );

Route::get('/fileJawaban/{file}', 'JawabanController@download' );

Route::get('/likePertanyaan/{id}', 'ProfileController@likePertanyaan');

Route::get('/dislikePertanyaan/{id}', 'ProfileController@dislikePertanyaan');

Route::get('/likeJawaban/{id}', 'ProfileController@likeJawaban');

Route::get('/dislikeJawaban/{id}', 'ProfileController@dislikeJawaban');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});