<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//mentor api route
Route::get('mentors', 'Api\MentorController@index');
Route::get('mentors/{id}', 'Api\MentorController@show');
Route::post('mentors', 'Api\MentorController@create');
Route::put('mentors/{id}', 'Api\MentorController@update');
Route::delete('mentors/{id}', 'Api\MentorController@delete');
