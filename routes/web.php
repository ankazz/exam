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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/job', 'HomeController@job');

Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('tms', 'TMSController');
    Route::resource('edizm', 'EdIzmController');
    Route::resource('service', 'ServiceController');
    Route::resource('task', 'TaskController');
    Route::resource('ttms', 'typeTMSController');
    Route::get('/home', 'HomeController@index')->name('home');   
});

//Users
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/users', 'UserController@index')->name('userIndex');
    Route::get('/users/edit/{id}', 'UserController@edit')->name('userEdit');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::get('/users/destroy/{id}', 'UserController@destroy');
    Route::get('/users/getRoles/{id}', 'UserController@getRoles');
    Route::post('/users/updateRole', 'UserController@updateRole');
});
