<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/', 'Home::store');
$routes->get('/fetch-image', 'Home::fetchImage');
<<<<<<< HEAD
$routes->get('dropbox/callback', 'DropboxController::callback');
=======
$routes->post('/delete-image', 'Home::deleteImage');
>>>>>>> ac87d04669c78c1804a7fb6775b6057b57725c45

// $routes->get('/', 'Home::listImages');

