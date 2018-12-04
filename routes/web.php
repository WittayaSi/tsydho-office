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
    return view('index_old');
});
Auth::routes();
Route::resource('/frontend/tasks', 'TaskController');


Route::resource('/frontend/car-uses', 'CarUseController');
Route::resource('/backend/setting/users', 'UserController');
Route::resource('/backend/setting/cars', 'SettingCarController');

Route::get('/backend', 'SettingController@index')->name('admin');

Route::get('/customer-api/get-all-cars', 'CustomerApiController@getAllCars');
Route::post('/customer-api/check-car', 'CustomerApiController@checkCar');


