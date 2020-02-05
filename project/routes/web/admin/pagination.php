<?php

/**
 * Pagination routes for admin
 * Prefix 'admin', middleware 'auth:'web', 'auth', 'verified', 'user-type:ADMIN'
 * Name 'admin.'
 * Namespace 'App\Http\Controllers\Admin
 */

/** Users */
Route::get('admin-users', 'AdminUserController@pagination')->name('admin-users');
Route::get('client-users', 'ClientUserController@pagination')->name('client-users');
