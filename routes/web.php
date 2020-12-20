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
//     return view('welcome');
// });


Route::get('/products/{id}','ProductsController@products');

Route::match(['get','post'],'/admin','AdminController@login');



Route::group(['middleware' =>['AdminLogin']],function(){
Route::match(['get','post'],'/admin/dashboard','AdminController@dashboard');
Route::match(['get','post'],'/admin/user-profile','AdminController@changePassword');

//Product Route
Route::match(['get','post'],'/admin/add-product','ProductsController@addProduct');
Route::match(['get','post'],'/admin/view-products','ProductsController@viewProducts');
Route::match(['get','post'],'/admin/edit-product/{id}','ProductsController@editProduct');
Route::match(['get','post'],'/admin/delete-product/{id}','ProductsController@DeleteProduct');

});
Route::get('/logout','AdminController@logout');
