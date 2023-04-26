<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;











Route::post('new_level','App\Http\Controllers\LevelController@new_level');
Route::post('new_subject','App\Http\Controllers\SubjectController@new_subject');
Route::post('new_section','App\Http\Controllers\SectionController@new_section');
Route::post('new_lesson','App\Http\Controllers\LessonController@new_lesson');

Route::post('gg','App\Http\Controllers\UserController@gg');



Route::post('level_data','App\Http\Controllers\SchoolController@level_data');
Route::post('add_like','App\Http\Controllers\SchoolController@add_like')->middleware('auth:api');
Route::get('get_all_subjects','App\Http\Controllers\SchoolController@get_all_subjects')->middleware('auth:api');
//Route::get('get_all_subjects','App\Http\Controllers\SchoolController@get_all_subjects');


Route::post('register','App\Http\Controllers\UserController@register');
Route::post('login','App\Http\Controllers\UserController@login');
Route::post('logout','App\Http\Controllers\UserController@logout');
Route::get('verify','App\Http\Controllers\UserController@verify');
Route::post('activate','App\Http\Controllers\UserController@activate');
Route::post('forgot','App\Http\Controllers\UserController@forgot');
Route::post('chang_pass','App\Http\Controllers\UserController@chang_pass');

Route::post('generate','App\Http\Controllers\CouponController@generate');

Route::post('subscriber','App\Http\Controllers\SubscriberController@subscriber');
