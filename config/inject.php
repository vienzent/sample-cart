<?php declare(strict_types=1);

use App\HelloWorld;
use App\Contracts\View\EngineInterface;
use App\View\Engine;
use eftec\bladeone\BladeOne;
use Zend\Diactoros\Response;
use function DI\create;
use function DI\get;

use Doctrine\ORM\EntityManager;

$entityManager = require __DIR__ . '/doctrine.php';

return [
    HelloWorld::class => create(HelloWorld::class)
        ->constructor(get('Foo'), get(Response::class)),
    'Foo' => 'bar',
    Response::class => function() {
        return new Response();
    },
    EngineInterface::class => create(Engine::class)
        ->constructor(function() { // TODO: create an adapter
            return new BladeOne(__DIR__ .'/../resources/views',__DIR__ .'/../cache/view',BladeOne::MODE_AUTO);
        }),
    \App\Contracts\Validator\ValidatorInterface::class => create(\App\Validator\Validator::class)
        ->constructor(function(){
            return new \GUMP;
        }),

    /* Repositories */
    \App\Contracts\Repositories\ProductRepositoryInterface::class => create(\App\Repositories\ProductRepository::class)
        ->constructor($entityManager),
    \App\Contracts\Repositories\UserRepositoryInterface::class => create(\App\Repositories\UserRepository::class)
        ->constructor($entityManager),
    \App\Contracts\Repositories\OrderRepositoryInterface::class => create(\App\Repositories\OrderRepository::class)
        ->constructor($entityManager),
    \App\Contracts\Repositories\OrderLineRepositoryInterface::class => create(\App\Repositories\OrderLineRepository::class)
        ->constructor($entityManager),
    \App\Contracts\Repositories\ProductRatingRepositoryInterface::class => create(\App\Repositories\ProductRatingRepository::class)
        ->constructor($entityManager),

    /* Services */
    \App\Contracts\Services\ProductServiceInterface::class => create(\App\Services\ProductService::class)
        ->constructor(
            get(\App\Contracts\Repositories\ProductRepositoryInterface::class),
            get(\App\Contracts\Repositories\ProductRatingRepositoryInterface::class)
        ),
    \App\Contracts\Services\UserServiceInterface::class => create(\App\Services\UserService::class)
        ->constructor(
            get(\App\Contracts\Repositories\UserRepositoryInterface::class)
        ),
    \App\Contracts\Services\ShopServiceInterface::class => create(\App\Services\ShopService::class)
        ->constructor(
            get(\App\Contracts\Repositories\UserRepositoryInterface::class),
            get(\App\Contracts\Repositories\OrderRepositoryInterface::class),
            get(\App\Contracts\Repositories\OrderLineRepositoryInterface::class),
            get(\App\Contracts\Repositories\ProductRepositoryInterface::class)
        ),

    \App\Contracts\Services\OrderServiceInterface::class => create(\App\Services\OrderService::class)
        ->constructor(
            get(\App\Contracts\Repositories\OrderRepositoryInterface::class)
        ),

    /* ADMIN CONTROLLERS */
    \App\Controllers\Admin\ProductController::class => create(\App\Controllers\Admin\ProductController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class),
            get(\App\Contracts\Services\ProductServiceInterface::class),
            get(\App\Contracts\Validator\ValidatorInterface::class)
        ),

    /* FRONT CONTROLLERS */
    \App\Controllers\ShopController::class => create(\App\Controllers\ShopController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class),
            get(\App\Contracts\Services\ProductServiceInterface::class ),
            get(\App\Contracts\Validator\ValidatorInterface::class),
            get( \App\Contracts\Services\ShopServiceInterface::class),
            get( \App\Contracts\Services\UserServiceInterface::class)
        ),
    \App\Controllers\HomeController::class => create(\App\Controllers\HomeController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class)
        ),

    \App\Controllers\AboutController::class => create(\App\Controllers\AboutController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class)
        ),

    \App\Controllers\ContactController::class => create(\App\Controllers\ContactController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class)
        ),

    \App\Controllers\OrderController::class => create(\App\Controllers\OrderController::class)
        ->constructor(
            get(EngineInterface::class),
            get(Response::class),
            get(\App\Contracts\Services\OrderServiceInterface::class),
            get(\App\Contracts\Services\UserServiceInterface::class)
        ),


];