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


Route::group([
  'namespace'  => 'App\Http\Controllers',
], function () {
  Route::get('/', 'PageController@index')->name('home');
  Route::get('/{slug}', 'PageController@page')->name('page');
  // Route::get('/', 'PageController@closed')->name('closed');

  Route::post('/review', 'ReviewController@create');
  Route::post('/review/{id}/like', 'ReviewController@like');
  Route::post('/review/{id}/remove-like', 'ReviewController@removeLike');
});