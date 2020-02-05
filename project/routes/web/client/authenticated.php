<?php

/**
 * Authenticated routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:CLIENT'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Client
 */

/** Profile */
Route::get('profile', 'ProfileController@index')->name('profile');
Route::put('profile', 'ProfileController@update')->name('profile.update');
