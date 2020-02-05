<?php

/**
 * Authenticated routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

/** Profile */
Route::get('profile', 'ProfileController@index')->name('profile');
Route::put('profile', 'ProfileController@update')->name('profile.update');

/** Users */
Route::resource('admin-users', 'AdminUserController', ['parameters' => ['admin-users' => 'id']]);
Route::resource('client-users', 'ClientUserController', ['parameters' => ['client-users' => 'id']]);
