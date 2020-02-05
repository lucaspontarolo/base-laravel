<?php

/**
 * Authenticated routes
 * Middleware 'auth'
 */

 /** Auth */
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/** Home */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

