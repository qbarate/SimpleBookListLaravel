<?php

Route::get('/', 'HomeController@index');

Route::get( '/books',               'BooksController@list');
Route::get( '/books/create',        'BooksController@create');
Route::get( '/books/{id}/edit',     'BooksController@edit');
Route::post('/books',               'BooksController@store')->name('store-book');
Route::post('/books/{id}/update',   'BooksController@update')->name('update-book');
Route::post('/books/delete',        'BooksController@destroy')->name('delete-book');