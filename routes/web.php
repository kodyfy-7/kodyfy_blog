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

Auth::routes();

Route::get('/', 'HomeController@index')->name('welcome');
Route::get('/post/{post}', 'HomeController@show');
Route::post('/post', 'HomeController@comment_save')->name('comment.save');
Route::get('/category/{category}', 'HomeController@show_category');

Route::any('/search', 'HomeController@search')->name('search');

Route::get('/home', 'HomeController@dashboard')->name('home');
Route::post('/upload', 'HomeController@upload_invoice')->name('invoice.upload');
Route::post('/save_wallet', 'HomeController@save_wallet')->name('save.wallet');
Route::get('/withdrawal', 'HomeController@withdraw')->name('dashboard.withdraw');
Route::post('/withdrawal', 'HomeController@withdrawal')->name('dashboard.withdrawal');


Route::get('admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
Route::resource('admin/posts', 'PostsController')->middleware('is_admin');
Route::get('admin/view_invoice/{invoice}', 'HomeController@view_invoice')->middleware('is_admin');

Route::post('admin/activate', 'HomeController@activate_account')->name('admin.activate_account');
Route::post('/confirm', 'HomeController@confirm_payment')->name('admin.confirm_payment')->middleware('is_admin');

  //Route::post('/confirm', 'AdminController@confirm_payment')->name('admin.confirm_payment');
/*Route::group(['middleware' => 'auth'], function() {

});*/
//Route::post('admin/posts/{id}', 'PostsController@publish')->middleware('is_admin');

//Route::post('admin/posts/{id}', 'PostsController@unpublish')->middleware('is_admin');

/*Route::get('admin/create_post', 'HomeController@create_post')->name('post.add')->middleware('is_admin');
Route::get('admin/{post}/edit_post/', 'HomeController@edit_post')->name('post.edit')->middleware('is_admin');
Route::post('admin/update_post/{post}', 'HomeController@update_post')->name('post.update')->middleware('is_admin');
Route::post('admin/create_post', 'HomeController@save_post')->name('post.save')->middleware('is_admin');
Route::post('admin/destroy_post', 'HomeController@destroy_post')->name('post.destroy')->middleware('is_admin');*/