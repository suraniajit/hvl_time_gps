<?php

use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'auth'
        ], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgetpassword', 'AuthController@forgetPassword');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::get('logout', 'AuthController@logout');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('customer_audit')->group(function() {
    Route::post('/', [
        'as' => 'api.audit.index',
        'uses' => 'hvl\AuditManagement\AuditController@filter',
        // 'middleware' => 'can:index audit'
    ]);
});
