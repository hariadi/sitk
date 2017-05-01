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
    return redirect(route('dashboard'));
});

Route::resource('reservations', 'ReservationController');
Route::resource('vehicles', 'VehicleController');
Route::resource('drivers', 'DriverController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
