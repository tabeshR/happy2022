<?php

use Illuminate\Support\Facades\Route;

Route::get('','AdminController@index');
Route::resource('users','UserController')->except(['show']);

Route::resource('permissions','PermissionController')->except(['show']);
Route::resource('roles','RoleController')->except(['show']);
Route::resource('products','ProductController')->except(['show']);
Route::resource('comments','CommentController')->except(['show','create','store']);
Route::post('attribute/values','AttributeController@getValues');
