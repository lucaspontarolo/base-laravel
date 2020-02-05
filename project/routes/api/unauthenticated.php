<?php

/**
 * Unauthenticated routes for Api
 * Prefix 'api/v1/client'
 * Namespace 'App\Http\Controllers\Api\v1\Client'
 */

// Auth
Route::post('login', 'AuthController@login');
