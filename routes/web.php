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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth/token', 'Auth\AuthTokenController@getToken');
Route::post('/auth/token', 'Auth\AuthTokenController@postToken')->name('authy.check');
Route::get('/auth/token/resend', 'Auth\AuthTokenController@getResend')->name('authy.check.resend');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/settings/twofactor', 'TwoFactorSettingsController@index')->name('twofactor.settings.index');
    Route::put('/settings/twofactor', 'TwoFactorSettingsController@update')->name('twofactor.settings.update');
});