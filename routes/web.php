<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/login','EmployerController@show_login_form')->name('login');
Route::post('/login_user','EmployerController@process_login')->name('login_user');
Route::get('/register','EmployerController@show_signup_form')->name('register');
Route::post('/register_user','EmployerController@process_signup');
Route::get('/logout','EmployerController@logout')->name('logout');
Route::post('/employee_create','EmployerController@register_employee');
Route::get('/employe_list','EmployerController@employe_list');
Route::post('/delete','EmployerController@delete');

    