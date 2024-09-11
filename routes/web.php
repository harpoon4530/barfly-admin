<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/users', 'UserController@index');
Route::get('/bars', 'BarController@index');
Route::get('/orders', 'OrderController@index');
Route::get('/promotions', 'PromotionController@index');
Route::get('/bar/create', 'BarController@create');
Route::get('/order/create', 'OrderController@create');
Route::get('/promotion/create', 'PromotionController@create');
Route::post('/bar/store', 'BarController@store');
Route::post('/order/store', 'OrderController@store');
Route::post('/promotion/store', 'PromotionController@store');

// User routes
Route::prefix('/user')->group(function() {
    Route::post('/{id}/edit',[
        'as' => 'user.edit',
        'uses' => 'UserController@edit'
    ]);
    Route::post('/{id}/update',[
        'as' => 'user.update',
        'uses' => 'UserController@update'
    ]);
    Route::delete('/{id}/delete',[
        'as' => 'user.destroy',
        'uses' => 'UserController@destroy'
    ]);
});

// Promotion routes
Route::prefix('/promotion')->group(function() {
    Route::post('/{id}/edit',[
        'as' => 'promotion.edit',
        'uses' => 'PromotionController@edit'
    ]);
    Route::post('/{id}/update',[
        'as' => 'promotion.update',
        'uses' => 'PromotionController@update'
    ]);
    Route::delete('/{id}/delete',[
        'as' => 'promotion.destroy',
        'uses' => 'PromotionController@destroy'
    ]);
});

// Bar routes
Route::prefix('/bar')->group(function() {
    Route::post('/{id}/edit',[
        'as' => 'bar.edit',
        'uses' => 'BarController@edit'
    ]);
    Route::post('/{id}/update',[
        'as' => 'bar.update',
        'uses' => 'BarController@update'
    ]);
    Route::delete('/{id}/delete',[
        'as' => 'bar.destroy',
        'uses' => 'BarController@destroy'
    ]);
    Route::match(array('GET', 'POST'), '/{id}/detail',[
        'as' => 'bar.show',
        'uses' => 'BarController@show'
    ]);

    // Menu category routes
    Route::post('/{id}/menu/category/create',[
        'as' => 'menu.category.create',
        'uses' => 'MenuCategoryController@create'
    ]);
    Route::post('/{id}/menu/category/store',[
        'as' => 'menu.category.store',
        'uses' => 'MenuCategoryController@store'
    ]);
    Route::delete('/{id}/menu/category/{cat_id}/delete',[
        'as' => 'menu.category.destroy',
        'uses' => 'MenuCategoryController@destroy'
    ]);

    // Menu modifier routes
    Route::post('/{id}/menu/modifier/create',[
        'as' => 'menu.modifier.create',
        'uses' => 'MenuModifierCategoryController@create'
    ]);
    Route::post('/{id}/menu/modifier/store',[
        'as' => 'menu.modifier.store',
        'uses' => 'MenuModifierCategoryController@store'
    ]);
    Route::delete('/{id}/menu/modifier/{cat_id}/delete',[
        'as' => 'menu.modifier.destroy',
        'uses' => 'MenuModifierCategoryController@destroy'
    ]);

    // Menu item routes
    Route::post('/{id}/menu/category/{cat_id}/item/create',[
        'as' => 'menu.category.item.create',
        'uses' => 'MenuItemController@create'
    ]);
    Route::post('/{id}/menu/category/{cat_id}/store',[
        'as' => 'menu.category.item.store',
        'uses' => 'MenuItemController@store'
    ]);
    Route::post('/{id}/menu/category/{cat_id}/item/{item}/edit',[
        'as' => 'menu.category.item.edit',
        'uses' => 'MenuItemController@edit'
    ]);
    Route::post('/{id}/menu/category/item/{item}/update',[
        'as' => 'menu.category.item.update',
        'uses' => 'MenuItemController@update'
    ]);
    Route::delete('/{id}/menu/category/item/{item}/delete',[
        'as' => 'menu.category.item.destroy',
        'uses' => 'MenuItemController@destroy'
    ]);

    // Menu modifier item routes
    Route::post('/{id}/menu/modifier/{cat_id}/item/create',[
        'as' => 'menu.modifier.item.create',
        'uses' => 'MenuModifierItemController@create'
    ]);
    Route::post('/{id}/menu/modifier/{cat_id}/store',[
        'as' => 'menu.modifier.item.store',
        'uses' => 'MenuModifierItemController@store'
    ]);
    Route::post('/{id}/menu/modifier/{cat_id}/item/{item}/edit',[
        'as' => 'menu.modifier.item.edit',
        'uses' => 'MenuModifierItemController@edit'
    ]);
    Route::post('/{id}/menu/modifier/item/{item}/update',[
        'as' => 'menu.modifier.item.update',
        'uses' => 'MenuModifierItemController@update'
    ]);
    Route::delete('/{id}/menu/modifier/item/{item}/delete',[
        'as' => 'menu.modifier.item.destroy',
        'uses' => 'MenuModifierItemController@destroy'
    ]);

    Route::get('/{id}/menu/get_modifiers', 'OrderController@get_menu_modifiers');
});

// Order routes
Route::prefix('/order')->group(function() {
    Route::post('/{id}/update', 'OrderController@update');
    Route::delete('/{id}/delete',[
        'as' => 'order.destroy',
        'uses' => 'OrderController@destroy'
    ]);
    Route::match(array('GET', 'POST'), '/{id}/detail',[
        'as' => 'order.show',
        'uses' => 'OrderController@show'
    ]);
});