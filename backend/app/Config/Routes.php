<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->post('login', 'AuthController::login');
    $routes->post('logout', 'AuthController::logout', ['filter' => 'auth']);
    $routes->get('me', 'AuthController::me', ['filter' => 'auth']);
});
service('auth')->routes($routes);

