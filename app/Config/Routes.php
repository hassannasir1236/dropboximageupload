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
<<<<<<< HEAD
$routes->get('dropbox/authorize', 'DropboxController::authorize');
$routes->get('dropbox/callback', 'DropboxController::callback');
=======
>>>>>>> ac87d04669c78c1804a7fb6775b6057b57725c45

>>>>>>> 5c2f0d691d4494b14ffccbd2d0c14e724faf7c18
// $routes->get('/', 'Home::listImages');

