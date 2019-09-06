<?php

use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download', function () {
    // Replace the storage path and file name based on your storage path and file name
    $data = response()->download(storage_path('app/public/sample.txt'), 'sample.txt');
    return $data;
});

Route::get('myfirstpage', function() {
    return 'hello world';
});

Route::get('mysecondpage', function() {
    return 'hello world 3';
})->middleware('auth:web');

Auth::routes();

Route::get('/home', 'HomeController@index');
