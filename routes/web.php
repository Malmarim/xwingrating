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
Route::get('/', 'RatingController@index');
Route::get('/upload', 'RatingController@uploadPage');
Route::post('/upload', 'RatingController@upload');
Route::get('/reset', 'RatingController@reset');

Route::get('/upload-test', 'RatingController@uploadTestPage');
Route::post('/upload-test', 'RatingController@uploadTest');
