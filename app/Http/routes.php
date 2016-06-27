<?php
Route::get('/', function() {
    return View::make('index'); 
});

Route::get('/api/lambs', 'LambController@index');
Route::get('/api/begins', 'LambController@begin');
Route::post('/api/lamb/nextday', 'LambController@nextday');
Route::post('/api/lamb/create', 'LambController@create');
Route::post('/api/lamb', 'LambController@update');
Route::delete('/api/lamb/{id}', 'LambController@destroy');