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
    $routes->get('container', 'ContainersController::index');
    $routes->get('content', 'ContentController::index');
    $routes->add('content/(:any)', 'ContentController::$1');
    $routes->add('container/(:any)', 'ContainersController::$1');
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


$routes->get('content/(:any)', 'Content::index');
$routes->get('container/(:any)', 'container::index');
$routes->get('/', 'Home::index');




$routes->setAutoRoute(true); 