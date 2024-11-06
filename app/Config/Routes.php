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

   // Container base routes
   $routes->get('containers', 'ContainersController::index');
   $routes->get('containers/create', 'ContainersController::create');
   $routes->post('containers/store', 'ContainersController::store');
   $routes->get('containers/edit/(:num)', 'ContainersController::edit/$1');
   $routes->post('containers/update-metadata/(:num)', 'ContainersController::updateMetadata/$1');
   $routes->get('containers/delete/(:num)', 'ContainersController::delete/$1');

   // Container items routes
   $routes->get('containers/(:num)/items/add', 'ContainerItemsController::addItem/$1');
   $routes->post('containers/(:num)/items/store', 'ContainerItemsController::storeItem/$1');
   $routes->get('containers/(:num)/items/edit/(:segment)', 'ContainerItemsController::editItem/$1/$2');
   $routes->post('containers/(:num)/items/update/(:segment)', 'ContainerItemsController::updateItem/$1/$2');
   $routes->get('containers/(:num)/items/delete/(:segment)', 'ContainerItemsController::deleteItem/$1/$2');


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

$routes->get('container', 'ContainerController::index');
$routes->get('container/(:segment)', 'ContainerController::view/$1');
$routes->get('container/(:segment)/items/(:segment)', 'ContainerController::item/$1/$2');


$routes->setAutoRoute(true); 