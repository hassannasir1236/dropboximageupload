<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::store');
$routes->get('/fetch-image', 'Home::fetchImage');
// $routes->get('/', 'Home::listImages');

