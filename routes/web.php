<?php

Route::get('/', 'HomeController@index');

Route::get( '/books',               'BooksController@list');
Route::get( '/books/create',        'BooksController@create');
Route::get( '/books/{id}/edit',          'BooksController@edit');
Route::post('/books',               'BooksController@store');
Route::post('/books/{id}/update',   'BooksController@update');

// TODOQBA No support for delete ? What about csrf ?
Route::post('/books/delete', 'BooksController@destroy');