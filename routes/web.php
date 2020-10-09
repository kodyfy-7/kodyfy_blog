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

Route::post('/pay', 'RaveController@initialize')->name('pay');
Route::post('/rave/callback', 'RaveController@callback')->name('callback');

Auth::routes();

Route::get('/', 'HomeController@index')->name('welcome');
Route::get('/post/{post}', 'HomeController@show');
Route::post('/post', 'HomeController@comment_save')->name('comment.save');
Route::get('/category/{category}', 'HomeController@show_category');

Route::any('/search', 'HomeController@search')->name('search');
Route::get('/about', function () {
  return view('about');
})->name('about');

Route::get('/home', 'HomeController@dashboard')->name('home');
Route::post('/upload', 'HomeController@upload_invoice')->name('invoice.upload');
Route::post('/save_wallet', 'HomeController@save_wallet')->name('save.wallet');
Route::get('/withdrawal', 'HomeController@withdraw')->name('dashboard.withdraw');
Route::post('/withdrawal', 'HomeController@withdrawal')->name('dashboard.withdrawal');


Route::get('admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');

Route::get('admin/users/verification', 'HomeController@verification')->name('admin.verification')->middleware('is_admin');

Route::get('admin/users/verification/view_invoice/{invoice}', 'HomeController@view_invoice')->middleware('is_admin');

Route::post('admin/activate', 'HomeController@activate_account')->name('admin.activate_account');

Route::get('admin/users/withdrawal', 'HomeController@adwithdrawal')->name('admin.withdrawal')->middleware('is_admin');

Route::post('/confirm', 'HomeController@confirm_payment')->name('admin.confirm_payment')->middleware('is_admin');

Route::resource('admin/posts', 'PostsController')->middleware('is_admin');

Route::resource('admin/category', 'CategoriesController')->middleware('is_admin');

Route::resource('admin/users', 'AdminsController')->middleware('is_admin');

