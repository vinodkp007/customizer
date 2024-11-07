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




   $routes->group('gallery', function($routes) {
    $routes->get('/', 'GalleryController::index');
    $routes->get('modify/(:num)', 'GalleryController::modify/$1');
    $routes->post('save', 'GalleryController::save');
    $routes->post('update-order', 'GalleryController::updateOrder');
    $routes->get('delete-item/(:num)', 'GalleryController::deleteItem/$1');
});

    

});


   // Container base routes
   

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Home edit routes
    $routes->get('home-edit', 'EditHomeController::index');
    $routes->post('home-edit/addslide', 'EditHomeController::addSlide');
    $routes->post('home-edit/updateslide', 'EditHomeController::updateSlide');
    $routes->post('home-edit/deleteslide/(:num)', 'EditHomeController::deleteSlide/$1');
    $routes->get('home-edit/getSlide/(:num)', 'EditHomeController::getSlide/$1');
    $routes->get('home-edit/getComponent/(:num)', 'EditHomeController::getComponent/$1');
    $routes->get('home-edit/getComponentItem/(:num)', 'EditHomeController::getComponentItem/$1');
    $routes->add('home-edit/(:any)', 'EditHomeController::$1');
});




$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('navbarmanager', 'NavbarManager::index');
    $routes->post('navbarmanager/add', 'NavbarManager::add');
    $routes->post('navbarmanager/delete/(:num)', 'NavbarManager::delete/$1');
    $routes->post('navbarmanager/updateorder', 'NavbarManager::updateOrder');
    $routes->add('(:any)','AdminController::$1');

});


$routes->get('gallery', 'GalleryController::index');
$routes->get('gallery/(:segment)', 'GalleryController::index/$1');
$routes->get('content/(:any)', 'Content::index');
$routes->get('container/(:any)', 'container::index');
$routes->get('/', 'Home::index');




$routes->setAutoRoute(true); 