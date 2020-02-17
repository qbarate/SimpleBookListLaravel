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

Route::get('/', 'BooksController@index');

Route::get('/Book/List', 'BooksController@list');

Route::get('/Book/Create', 'BooksController@create');

Route::post('/Book/Submit', 'BooksController@submit');

Route::get('/Book/Update/{id}', 'BooksController@update');

Route::get('/Book/Delete/{id}', 'BooksController@delete'); // TODO Change to DELETE to implement csrf