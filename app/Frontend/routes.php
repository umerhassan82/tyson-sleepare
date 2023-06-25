<?php
Route::prefix('uploads/products/')->group(function () {
    Route::get('big/{pic}', ['as' => 'image.big', 'uses' => 'ImageController@big']);
    Route::get('medium/{pic}', ['as' => 'image.medium', 'uses' => 'ImageController@medium']);
    Route::get('small/{pic}', ['as' => 'image.small', 'uses' => 'ImageController@small']);
});

Auth::routes();
Route::group(['middleware' => 'shop'], function () {
    Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
    Route::get('/email', ['as' => 'home', 'uses' => 'CheckoutController@emailTest']);
    Route::get('/test/curl', ['as' => '/test/curl', 'uses' => 'HomeController@testCurl']);
    Route::get('/get/keywords/{value?}', 'HomeController@getKeywords');
    Route::get('/api/orders', 'OrderController@getOrders');
    Route::get('/cancel/order/{id}', 'CheckoutController@cencelOrder');
    Route::post('/cancel/request/order/{id}', 'CheckoutController@cancelOrderRequest');
    Route::post('checkout', ['as' => 'checkout', 'uses' => 'CheckoutController@proceedPayment']);
    Route::get('/formdata/{data?}', ['as' => '/formdata', 'uses' => 'CheckoutController@savesession']);
    Route::post('place-order', ['as' => 'place-order', 'uses' => 'CheckoutController@proceedPayment']);
    Route::post('/custom/add', ['as' => 'custom.add', 'uses' => 'CartController@store_custom']);
    Route::get('thank-you', ['as' => 'thank-you', 'uses' => 'CheckoutController@thankyou']);
    Route::get('cancelled', ['as' => 'cancelled', 'uses' => 'CheckoutController@cancelled']);
    Route::get('{id}-{slug}', ['as' => 'products.show', 'uses' => 'ProductController@show'])->where('id', '[0-9]+');
    Route::get('cart', ['as' => 'cart.index', 'uses' => 'CartController@index']);
    Route::post('cart', ['as' => 'cart.store', 'uses' => 'CartController@store']);
    Route::get('cart/{id}', ['as' => 'cart.destroy', 'uses' => 'CartController@destroy']);
    Route::post('search', ['as' => 'search', 'uses' => 'SearchController@index']);
    Route::get('search/{story}', ['as' => 'search.index', 'uses' => 'SearchController@index']);
    Route::get('{slug}.html', ['as' => 'pages.index', 'uses' => 'PageController@index']);
    Route::post('orders', ['as' => 'orders.store', 'uses' => 'OrderController@store']);
    Route::get('{path}', ['as' => 'categories.show', 'uses' => 'CategoryController@show'])->where('path', '[a-zA-Z0-9/_-]+');
});

Route::post('/checkmail', 'HomeController@checkmail');
Route::post('/purchase', 'HomeController@purchase');
Route::post('/sendmail', 'HomeController@sendmail');
