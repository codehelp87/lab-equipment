<?php

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

Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/home/profile', 'UserController@viewMyProfile')
    ->name('my_profile');

Route::get('/users/{status}/view', 'UserController@gettUserStatus');
Route::get('/users/{userId}/edit', 'UserController@editUserAccount');
Route::post('/users/{userId}/update', 'UserController@updateUserAccount');
Route::put('/users/{email}/password_change', 'UserController@changePassword');

Route::post('/labs/add', 'LabController@createLab');
Route::get('/labs/{id}/users', 'LabController@getLabUsers');
Route::put('/labs/{id}/add', 'LabController@assignUserToLab');

Route::post('/equipments/{id}/update', 'EquipmentController@updateEquipment');
Route::get('/equipments/{id}/booking', 'EquipmentController@bookEquipment');
Route::post('/equipments/add', 'EquipmentController@createEquipment');
Route::get('/equipments/{id}', 'EquipmentController@editEquipment');
