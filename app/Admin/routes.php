<?php
use Illuminate\Routing\Router;


Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([
        'pages' => PageController::class,
        'shop/categories' => Shop\CategoryController::class,
        'shop/products' => Shop\ProductController::class,
        'shop/orders' => Shop\OrderController::class,
    ]);
   
   $router->resource('order/items', OrderItemController::class);

   $router->resource('shop/brands', BrandController::class);
   
   $router->resource('shop/home/products', HomeProductController::class);

});
