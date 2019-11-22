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

Route::get('/', function () {return view('index');});//Main Page
Route::get('/stack', function () {return view('stack');});//showing stack page
Route::post('/stack', 'VideoController@stack');//execute stacking process
Route::get('/test', 'VideoController@test');//for testing purposes
Route::get('/extract', function () {return view('extract');});//showing extract page
Route::post('/extract','VideoController@extract');//executing extract process
