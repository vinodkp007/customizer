<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * 
 * 
 */
// Make sure this is above any other routes that might conflict
$routes->group('/admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->add('(:any)','AdminController::$1');

});

// $routes->group('/admin/navbarmanager', ['namespace' => 'App\Controllers\Admin'], function($routes) {
//     $routes->get('/', 'Navbarmanager::index');
//     $routes->add('(:any)','Navbarmanager::$1');
// });



$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('navbarmanager', 'NavbarManager::index');
    $routes->post('navbarmanager/add', 'NavbarManager::add');
    $routes->post('navbarmanager/delete/(:num)', 'NavbarManager::delete/$1');
    $routes->post('navbarmanager/updateorder', 'NavbarManager::updateOrder');
});
$routes->get('/', 'Home::index');




$routes->setAutoRoute(true); 