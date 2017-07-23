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

// Route::get('/', function () {
//     // return view('welcome');
//     return view('index');
// });
Route::GET('/','PageController@index');
Route::GET('collections/{category}','PageController@collections')->name('customer.collections');

Route::GET('admin/home','AdminController@index');

Route::GET('admin', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::POST('admin', 'Admin\LoginController@login');
Route::POST('admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');  
Route::GET('admin-password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::POST('admin-password/reset','Admin\ResetPasswordController@reset');
Route::GET('admin-password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

Route::resource('admin/category', 'Admin\CategoryController');
Route::resource('admin/size', 'Admin\SizeController');
Route::resource('admin/colour', 'Admin\ColourController');
Route::resource('admin/product', 'Admin\ProductController');
Route::resource('admin/asset', 'Admin\AssetController');

Route::POST('admin/assetAssignment/create', 'Admin\AssetAssignmentController@create')->name('assetAssignment.create');;
Route::POST('admin/assetAssignment/update', 'Admin\AssetAssignmentController@update')->name('assetAssignment.update');;
Route::POST('admin/assetAssignment/delete', 'Admin\AssetAssignmentController@destroy')->name('assetAssignment.destroy');;

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
