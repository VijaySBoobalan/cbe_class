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

// Auth::routes(['verify' => true]);

    // Route::post('login', 'Auth\AuthController@login');
    // Route::post('register', 'HomeController@store');
    // Route::group(['middleware' => 'auth:api'], function(){
    //     Route::get('getUser', 'HomeController@getUser');
    // });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('subscribe-cancel', [
    // 'as' => 'subscribe-cancel',
    'uses' => 'PayuMoneyController@SubscribeCancel'
]);

Route::POST('subscribe-response', [
    // 'as' => 'subscribe-response',
    'uses' => 'PayuMoneyController@SubscribeResponse'
]);

// Route::get('stripe', 'StripePaymentController@stripe');
// Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
