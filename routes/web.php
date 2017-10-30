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
Route::GET('/home', 'PageController@index')->name('home');
Route::GET('/','PageController@index')->name('customer.index');

Route::GET('collections/{category}','PageController@collections')->name('customer.collections');
Route::GET('collections/{category}/{product}','PageController@collection')->name('customer.collections.detail');
Route::GET('add-to-cart/{productStockId}/{qty}','PageController@addToCart')->name('customer.add-to-cart');
Route::GET('view-cart','PageController@viewCart')->name('customer.view-cart');
Route::POST('remove-cart','PageController@removeCart')->name('customer.remove-cart');
Route::GET('clear-cart','PageController@clearCart')->name('customer.clear-cart');
Route::GET('shipping-address','CheckoutController@indexShippingAddress')->name('customer.shipping-address');
Route::POST('shipping-address','CheckoutController@saveShippingAddress')->name('customer.shipping-address-save');
// Route::GET('shipping-payment','CheckoutController@indexShippingPayment')->name('customer.shipping-payment');
Route::POST('review-order','CheckoutController@reviewOrder')->name('customer.review-order'); // pick shipping service
Route::POST('confirm-order','CheckoutController@confirmOrder')->name('customer.confirm-order');


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
Route::resource('admin/order', 'Admin\OrderController');
Route::POST('admin/order/search', 'Admin\OrderController@search')->name('order.search');

Route::POST('admin/assetAssignment/create', 'Admin\AssetAssignmentController@create')->name('assetAssignment.create');;
Route::POST('admin/assetAssignment/update', 'Admin\AssetAssignmentController@update')->name('assetAssignment.update');;
Route::POST('admin/assetAssignment/delete', 'Admin\AssetAssignmentController@destroy')->name('assetAssignment.destroy');

Route::POST('admin/productStock/create', 'Admin\ProductStockController@create')->name('productStock.create');
Route::POST('admin/productStock/update', 'Admin\ProductStockController@update')->name('productStock.update');
Route::POST('admin/productStock/delete', 'Admin\ProductStockController@destroy')->name('productStock.destroy');


Auth::routes();

