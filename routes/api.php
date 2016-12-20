<?php

use Illuminate\Http\Request;

Route::get('users','UserController@users');
Route::post('auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');

Route::get('users/profile','UserController@profile')->middleware('auth:api');

Route::post('post','PostController@add')->middleware('auth:api');

//Bearer

