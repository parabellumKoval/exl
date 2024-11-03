<?php

use Illuminate\Support\Facades\Route;

use App\Models\Page;

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
  //
  $home_page = Page::where('is_home', 1)->first();
  if(!empty($home_page->slug) || $home_page->slug !== '/') {
    Route::redirect('/', '/' . $home_page->slug, 302);
    Route::get('/' . $home_page->slug, 'PageController@index')->name('home');
  }else {
    Route::get('/', 'PageController@index')->name('home');
  }

  // 
  Route::get('/{slug}', 'PageController@page')->name('page');

  Route::post('/review', 'ReviewController@create');
  Route::post('/review/{id}/like', 'ReviewController@like');
  Route::post('/review/{id}/remove-like', 'ReviewController@removeLike');
});