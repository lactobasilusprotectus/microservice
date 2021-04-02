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

//courses api router
Route::get('course', 'Api\CourseController@index');
Route::get('course/{id}', 'Api\CourseController@show');
Route::post('course', 'Api\CourseController@create');
Route::put('course/{id}', 'Api\CourseController@update');
Route::delete('course/{id}', 'Api\CourseController@delete');

//chapter api router
Route::post('chapters', 'Api\ChapterController@create');
Route::put('chapters/{id}', 'Api\ChapterController@update');
Route::get('chapters', 'Api\ChapterController@index');
Route::get('chapters/{id}', 'Api\ChapterController@show');
Route::delete('chapters/{id}', 'Api\ChapterController@delete');

//lesson api router
Route::post('lessons', 'Api\LessonController@create');
Route::put('lessons/{id}', 'Api\LessonController@update');
Route::get('lessons', 'Api\LessonController@index');
Route::get('lessons/{id}', 'Api\LessonController@show');
Route::delete('lessons/{id}', 'Api\LessonController@delete');

//image course router
Route::post('image-courses', 'Api\ImageCourseController@create');
Route::delete('image-courses/{id}', 'Api\ImageCourseController@delete');

//my course router
Route::post('my-courses', 'Api\MyCourseController@create');
Route::get('my-courses', 'Api\MyCourseController@index');

//review course router
Route::post('reviews', 'Api\ReviewController@create');
Route::put('reviews/{id}', 'Api\ReviewController@update');
Route::delete('reviews/{id}', 'Api\ReviewController@delete');
