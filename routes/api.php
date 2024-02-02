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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});






Route::post('register', 'App\Http\Controllers\SchoolAPI\AuthenticationController@register');

Route::post('login', 'App\Http\Controllers\SchoolAPI\AuthenticationController@login');


Route::post('payment-process', 'App\Http\Controllers\Admin\FeePaymentController@paymentProcess');




Route::get('mobile-feed-notification', 'App\Http\Controllers\API\MobileAPIController@notificationFeed');