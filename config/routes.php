<?php declare(strict_types=1);

return [
    ['GET',     '/',  \App\Controllers\HomeController::class],
    ['GET',     '/about',  \App\Controllers\AboutController::class],
    ['GET',     '/contact',  \App\Controllers\ContactController::class],
    ['GET',     '/shop',  [\App\Controllers\ShopController::class, 'index']],
    ['POST',    '/cart/{product_id}',  [\App\Controllers\ShopController::class, 'addItem']],
    ['POST',    '/cart/{id}/delete',  [\App\Controllers\ShopController::class, 'deleteItem']],
    ['POST',    '/cart/{id}/qty',  [\App\Controllers\ShopController::class, 'updateItemQty']],
    ['GET',     '/cart',  [\App\Controllers\ShopController::class, 'cart']],
    ['POST',    '/checkout',  [\App\Controllers\ShopController::class, 'checkout']],
    ['GET',     '/orders',  [\App\Controllers\OrderController::class, 'index']],
    ['POST',    '/products/{id}/rate',  [\App\Controllers\ShopController::class, 'rate']],

    ['POST',    '/admin/products',  [\App\Controllers\Admin\ProductController::class, 'store']],
    ['GET',     '/admin/products',  [\App\Controllers\Admin\ProductController::class, 'index']],
    ['GET',     '/admin/products/create',  [\App\Controllers\Admin\ProductController::class, 'create']],
    ['GET',     '/admin/products/{id}/edit',  [\App\Controllers\Admin\ProductController::class, 'edit']],
    ['POST',    '/admin/products/{id}',  [\App\Controllers\Admin\ProductController::class, 'update']],
];
