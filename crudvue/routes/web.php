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

Route::get('/home', 'HomeController@index');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/users/list/{success?}/{message?}', 'UserController@index');
    Route::post('/api/users', 'UserController@getUsers');
    Route::get('/users/create', 'UserController@create');
    Route::post('/users/create', 'UserController@store');
    Route::get('/users/edit/{id}', 'UserController@edit');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::post('/users/delete/{id}', 'UserController@destroy');
    Route::get('/states/showStatesByCountry/{countryId}', 'StateController@getStatesByCountry');
    Route::get('/citys/showCitysByState/{stateId}', 'CityController@getCitysByState');
});

