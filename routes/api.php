<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', 'Api\UserController');
Route::resource('job', 'Api\JobController');
Route::put('job', 'Api\JobController@store');
Route::get('/job_total', 'Api\JobController@total');

Route::resource('post', 'Api\PostController');
Route::put('post', 'Api\PostController@store');
Route::get('/post_total', 'Api\PostController@total');

Route::resource('student', 'Api\StudentController');
Route::put('student', 'Api\StudentController@store');

Route::resource('category', 'Api\CategoryController');
Route::put('category', 'Api\CategoryController@store');

Route::resource('tms', 'Api\TMSController');
Route::put('tms', 'Api\TMSController@store');
Route::get('/tms_total', 'Api\TMSController@total')->name('tms.total');
Route::resource('edizm', 'Api\EdIzmController');
Route::put('edizm', 'Api\EdIzmController@store');
Route::resource('service', 'Api\ServiceController');
Route::put('service', 'Api\ServiceController@store');
Route::resource('task', 'Api\TaskController');
Route::put('task', 'Api\TaskController@store');
Route::resource('ttms', 'Api\typeTMSController');
Route::put('ttms', 'Api\typeTMSController@store');