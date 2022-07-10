<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();


Route::get('/', 'GuestController@home');

Route::get('/products', 'GuestController@shops');

Route::get('/product/details/{id}', 'GuestController@productDetails');

Route::get('/products/{category}/list', 'GuestController@shop');

Route::post('/products/search', 'GuestController@search');




Route::get('/home', 'HomeController@index')->name('home');

Route::get('/client/dashboard', 'ClientController@dashboard')->middleware('auth', 'is_active');

Route::get('/client/commandes', 'ClientController@mescommandes');

Route::get('/client/profile', 'ClientController@profile');

Route::post('/client/profile/update', 'ClientController@updateProfile')->middleware('auth'); // pour la mise à jour dans la base

Route::post('/client/review/store', 'ClientController@addReview')->middleware('auth'); // pour la mise à jour dans la base

Route::post('/client/order/store', 'CommandeController@store')->middleware('auth', 'is_active');

Route::get('/client/cart', 'ClientController@cart')->middleware('auth');

Route::get('/client/lc/{idlc}/destroy', 'CommandeController@LigneCommandeDestroy')->middleware('auth');

Route::post('/client/checkout', 'ClientController@checkout')->middleware('auth');

Route::get('/client/bloquer', 'ClientController@afficherMeassageBloquer')->middleware('auth');



Route::get('/admin/dashboard', 'AdminController@dashboard')->middleware('auth', 'admin');

Route::get('/admin/profile', 'AdminController@profile')->middleware('auth', 'admin'); //pour afficher la page profile

Route::post('/admin/profile/update', 'AdminController@updateProfile')->middleware('auth', 'admin'); // pour la mise à jour dans la base


Route::get('/admin/categories', 'CategoryController@index')->middleware('auth', 'admin');

Route::post('/admin/category/store', 'CategoryController@store')->middleware('auth', 'admin');

Route::post('/admin/category/update', 'CategoryController@update')->middleware('auth', 'admin');

Route::get('/admin/categorie/{id}/delete', 'CategoryController@destroy')->middleware('auth', 'admin');


Route::get('/admin/products', 'ProductController@index')->middleware('auth', 'admin');

Route::post('/admin/product/store', 'ProductController@store')->middleware('auth', 'admin');

Route::post('/admin/product/update', 'ProductController@update')->middleware('auth', 'admin');

Route::get('/admin/product/{id}/delete', 'ProductController@destroy')->middleware('auth', 'admin');


Route::get('/admin/clients', 'AdminController@clients')->middleware('auth', 'admin');

Route::get('/admin/user/{id}/bloquer', 'AdminController@BloquerUser')->middleware('auth', 'admin');

Route::get('/admin/user/{id}/debloquer', 'AdminController@DebloquerUser')->middleware('auth', 'admin');
