<?php

/**
 * This is the front controller of our application. 
 * All requests will go through this before reaching any of our web services. 
 * @author     Ryan Wilson <ryan.wilson@tuxedomoney.com>
 */

/**
 * We use strict_types to enforce php7 standards
 */

declare(strict_types=1);

/**
 * These dependencies are used for:
 *  our ioc container php-di
 *  Are router to route traffic to the correct web service.
 *  Are response object that we will use throughout all web services.
 */

use DI\ContainerBuilder;
use LendInvest\Controllers\AuthController as AuthController;

use LendInvest\Soap\SoapServiceSecure as SoapServiceSecure;

use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

use LendInvest\Redis\RedisManager;
use LendInvest\Handlers\LogHandler;

/**
 * All dependencies and classes for the APP namespace will be autoloaded here. 
 * This will save on the require statements.
 */

require_once 'vendor/autoload.php';

require_once "app/Soap/SoapServices.php";

/**
 * Bring in the global constants
 */

require_once 'config/config.php';

/** 
 * This is our depedency injection container. 
 * Which is responsible for injecting the ehttps://www.google.com/search?q=youi&oq=you&aqs=chrome.0.69i59j69i60j69i59j69i60j69i57j69i61.591j0j9&sourceid=chrome&ie=UTF-8xternal dependencies to our classes.
 * This is so that we can maintain the principle of solid - Dependency Inversion.
*/

$containerBuilder = new ContainerBuilder();

$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(true);


$redisManager = new RedisManager();

$logHandler = new LogHandler();

$containerBuilder->addDefinitions([
    AuthController::class => create(AuthController::class)
        ->constructor(get('SoapServiceSecure') ,  get('SoapServer') , get('RedisManager') , get('LogHandler') ),
    'SoapServiceSecure' => function (){
        return new SoapServiceSecure('LendInvest\Soap\SoapServices');
    },
    'SoapServer' => function (){
        return new SoapServer('soap.wsdl');
    },
    'RedisManager' => function (){
        return new RedisManager();
    },
    'LogHandler' => function (){
        return new LogHandler();
    },
]);

/**
 * We use the containerBuilder build method to return the resolved dependencies to the container variable.
 * This works in conjunction with our router and will invoke the class. 
 */

/** @noinspection PhpUnhandledExceptionInspection */
$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->post('/auth', AuthController::class);
});

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);

/** @noinspection PhpUnhandledExceptionInspection */

$requestHandler = new Relay($middlewareQueue);

$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
/** @noinspection PhpVoidFunctionResultUsedInspection */
return $emitter->emit($response);
