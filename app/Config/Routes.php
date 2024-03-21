<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('products', ['controller' => 'ProductController', 'namespace' => 'App\Controllers']);
