<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::store');
$routes->get('/fetch-image', 'Home::fetchImage');
$routes->post('/delete-image', 'Home::deleteImage');
$routes->get('dropbox/authorize', 'DropboxController::authorize');
$routes->get('dropbox/callback', 'DropboxController::callback');
// $routes->get('/', 'Home::listImages');

