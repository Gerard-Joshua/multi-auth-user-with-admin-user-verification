<?php


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
Route::post('/register', 'AdminAuth\RegisterController@register');
Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'AdminAuth\LoginController@login');
Route::get('/home', 'AdminHomeController@index')->name('admin.home');
Route::post('/update/user/status/{id}', 'AdminHomeController@update_user_status')->name('admin.update.user.status');
Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

//Forgot Password Routes
Route::get('/password/reset','AdminAuth\ForgotPasswordController@showForgetPasswordForm')->name('admin.password.request');
Route::post('/password/email','AdminAuth\ForgotPasswordController@submitForgetPasswordForm')->name('admin.password.email');

//Reset Password Routes
Route::get('/password/reset/{token}','AdminAuth\ResetPasswordController@showResetPasswordForm')->name('admin.password.reset');
Route::post('/password/reset','AdminAuth\ResetPasswordController@submitResetPasswordForm')->name('admin.password.update');
