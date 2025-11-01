<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'NumberController::index');
$routes->post('numbers/add', 'NumberController::add');
$routes->post('numbers/clear', 'NumberController::clear');
$routes->get('numbers/stats', 'NumberController::getStats');
$routes->post('numbers/generate', 'NumberController::generateRandom');
$routes->post('numbers/save', 'NumberController::saveGenerated');
