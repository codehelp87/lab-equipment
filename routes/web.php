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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('load_login');
Route::post('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::post('/login', 'Auth\LoginController@login');

Route::get('/training/register', 'UserController@requestForm')
    ->name('request_training');
Route::post('/training/request/create', 'UserController@createTrainingRequest')
	    ->name('create-training-request');

Route::get('users/account/blocked', function() {
    return view('student.account_blocked');
})->name('account_blocked');

Route::get('/labs/{id}/equipments', 'LabController@getLabEquipments');


Route::get('request/training/confirmation', function() {
    return view('student.training_request_confirmation');
})->name('training_request_confirmation');

Route::get('users/{hash}/activate', 'UserController@activateUserAccount');

Route::group(['middleware' => ['auth']], function () {

	Route::get('/home', 'HomeController@index')->name('dashboard');

	Route::get('/home/profile', 'UserController@viewMyProfile')
	    ->name('my_profile');

	Route::put('/users/{email}', 'UserController@editUserInfo');
	Route::get('/users/{status}/view', 'UserController@gettUserStatus');
	Route::get('/users/{userId}/edit', 'UserController@editUserAccount');
	Route::post('/users/{userId}/update', 'UserController@updateUserAccount');
	Route::put('/users/{email}/password_change', 'UserController@changePassword');
	Route::post('users/password/reset', 'Auth\ForgotPasswordController@getEmail');

	Route::post('equipments/training/completed', 'UserController@completeTraining')
	    ->name('training_completed_confirmation');

	Route::post('/equipments/training/confirmation', 'UserController@confirmTrainingRequest')
	    ->name('training_confirmation');

	Route::post('/labs/add', 'LabController@createLab');
	Route::get('/labs/{id}/users', 'LabController@getLabUsers');
	Route::put('/labs/{id}/add', 'LabController@assignUserToLab');

	Route::post('/equipments/booking', 'BookingController@addBooking');
	Route::get('bookings/{id}/cancel', 'BookingController@cancelBooking');

	Route::get('/equipments/{id}/lab_usage_by_session', 'EquipmentController@getLabUsersBySessionAndEquipment');
	Route::get('/equipments/{id}/labusers/sessions', 'EquipmentController@getLabUsersBySession');
	Route::get('/equipments/{id}/labusers/{lab_user}', 'EquipmentController@getLabUsers');
	Route::get('/equipments/{id}/students', 'EquipmentController@EquipmentUsers');
	Route::get('equipments/{id}/trainings', 'EquipmentController@TrainingUsers');
	Route::post('/equipments/{id}/update', 'EquipmentController@updateEquipment');
	Route::get('/equipments/{id}/booking', 'EquipmentController@bookEquipment');
	Route::get('/equipments/{id}/lab_usage', 'EquipmentController@getEquipmentLabUsage');
	Route::post('/equipments/add', 'EquipmentController@createEquipment');
	Route::get('/equipments/{id}', 'EquipmentController@editEquipment');

    Route::get('/my_notifications', function() {
    	return view('student.my_notifications');
    });
 
	Route::POST('/notifications/add', 'NotificationController@addNotification');
	Route::get('/notifications/{id}', 'NotificationController@editNotification');
	Route::post('/notifications/{id}/update', 'NotificationController@updateNotification');
});
