<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/student/{id}', function ($id) {
//     return "Hello $id";
// });

Route::get('/student/{id}', 'StudentController@showStudent');
Route::get('/student', 'StudentController@show');
Route::get('/tags', 'StudentController@tag');
