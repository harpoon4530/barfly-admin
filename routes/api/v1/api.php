<?php

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

Route::prefix('/user')->group(function() {
    Route::post('/login', 'api\v1\UserController@login');
    Route::post('/signup', 'api\v1\UserController@register');
    Route::post('/signup_social', 'api\v1\UserController@register_social');
    Route::get('/forgot_password', 'api\v1\UserController@forgot_password');
    Route::post('/register_device', 'api\v1\UserController@register_device');
    Route::post('/change_password', 'api\v1\UserController@change_password');
    Route::post('/update_password', 'api\v1\UserController@update_password');
    Route::post('/verify_code', 'api\v1\UserController@verify_code');
    Route::post('/delete_account', 'api\v1\UserController@delete_account');
    Route::post('/update_profile', 'api\v1\UserController@update_profile');

    Route::get('/{id}/orders', 'api\v1\OrderController@get_orders');
    Route::get('/{id}/notifications', 'api\v1\NoticationController@get_notication');
    Route::post('/add_card', 'api\v1\PaymentController@create_customer');
    Route::post('/select_card', 'api\v1\PaymentController@select_card');
    Route::post('/remove_card', 'api\v1\PaymentController@remove_card');
    Route::get('/charge_card', 'api\v1\PaymentController@create_charge'); // TEMPORARY ROUTE
    Route::get('/{id}/cards', 'api\v1\PaymentController@get_cards');
});

//Route::middleware('auth:api')->get('/bars', 'api\v1\UserController@get_bars');
Route::get('/bars', 'api\v1\BarController@get_bars');
Route::get('/bar/{id}/menu', 'api\v1\BarController@get_menu');
Route::get('/bar/{id}', 'api\v1\BarController@get_bar');
Route::get('/nearby', 'api\v1\BarController@get_nearby');

Route::post('/order/create', 'api\v1\OrderController@create_order');
Route::post('/order/update', 'api\v1\OrderController@update_order_status');

Route::get('/promotions', 'api\v1\PromotionController@get_promotions');

Route::get('/search/{search}', 'api\v1\SearchController@search_result');