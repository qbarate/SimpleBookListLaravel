<?php

Route::get('/', 'HomeController@index');

Route::get( '/books',               'BooksController@list');
Route::get( '/books/create',        'BooksController@create');
Route::post('/books',               'BooksController@store');
Route::get( '/books/Update/{id}',   'BooksController@update');

// TODOQBA No support for delete ? What about csrf ?
Route::post('/books/delete', 'BooksController@destroy');