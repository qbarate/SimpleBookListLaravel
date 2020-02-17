<?php

Route::get('/', 'BooksController@index');

Route::get('/Book/List', 'BooksController@list');

Route::get('/Book/Create', 'BooksController@create');

Route::post('/Book/Submit', 'BooksController@submit');

Route::get('/Book/Update/{id}', 'BooksController@update');

Route::post('/Book/Delete/', 'BooksController@delete');