<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Admin Routes Group
$routes->group('/admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Admin Dashboard
    $routes->get('/', 'AdminController::index');
    
    // Content Management Routes
    $routes->get('content', 'ContentController::index');
    $routes->add('content/(:any)', 'ContentController::$1');
    
    // Container Management Routes
    $routes->group('container', function($routes) {
        $routes->get('/', 'ContainersController::index');
        $routes->add('(:any)', 'ContainersController::$1');
    });

    // Containers CRUD Routes
    $routes->group('containers', function($routes) {
        $routes->get('/', 'ContainersController::index');
        $routes->get('create', 'ContainersController::create');
        $routes->post('store', 'ContainersController::store');
        $routes->get('edit/(:num)', 'ContainersController::edit/$1');
        $routes->post('update-metadata/(:num)', 'ContainersController::updateMetadata/$1');
        $routes->get('delete/(:num)', 'ContainersController::delete/$1');
        
        // Container Items Nested Routes
        $routes->group('(:num)/items', function($routes) {
            $routes->get('add', 'ContainerItemsController::addItem/$1');
            $routes->post('store', 'ContainerItemsController::storeItem/$1');
            $routes->get('edit/(:segment)', 'ContainerItemsController::editItem/$1/$2');
            $routes->post('update/(:segment)', 'ContainerItemsController::updateItem/$1/$2');
            $routes->get('delete/(:segment)', 'ContainerItemsController::deleteItem/$1/$2');
        });
    });

    // Gallery Management Routes
    $routes->group('gallery', function($routes) {
        $routes->get('/', 'GalleryController::index');
        $routes->get('modify/(:num)', 'GalleryController::modify/$1');
        $routes->post('save', 'GalleryController::save');
        $routes->post('update-order', 'GalleryController::updateOrder');
        $routes->get('delete-item/(:num)', 'GalleryController::deleteItem/$1');
    });

    // Home Edit Routes
    $routes->group('home-edit', function($routes) {
        $routes->get('/', 'EditHomeController::index');
        $routes->post('addslide', 'EditHomeController::addSlide');
        $routes->post('updateslide', 'EditHomeController::updateSlide');
        $routes->post('deleteslide/(:num)', 'EditHomeController::deleteSlide/$1');
        $routes->get('getSlide/(:num)', 'EditHomeController::getSlide/$1');
        $routes->get('getComponent/(:num)', 'EditHomeController::getComponent/$1');
        $routes->get('getComponentItem/(:num)', 'EditHomeController::getComponentItem/$1');
        $routes->add('(:any)', 'EditHomeController::$1');
    });

    // Navbar Management Routes
    $routes->group('navbarmanager', function($routes) {
        $routes->get('/', 'NavbarManager::index');
        $routes->post('add', 'NavbarManager::add');
        $routes->post('delete/(:num)', 'NavbarManager::delete/$1');
        $routes->post('updateorder', 'NavbarManager::updateOrder');
    });

    // Footer Management Routes
    $routes->group('footermanager', function($routes) {
        $routes->get('/', 'FooterManager::index');
        $routes->post('updateSettings', 'FooterManager::updateSettings');
        $routes->post('addSocialLink', 'FooterManager::addSocialLink');
        $routes->post('deleteSocialLink/(:num)', 'FooterManager::deleteSocialLink/$1');
        $routes->post('updateSocialLinksOrder', 'FooterManager::updateSocialLinksOrder');
        $routes->post('toggleSocialLink/(:num)', 'FooterManager::toggleSocialLink/$1');
        $routes->post('updateQuickLinks', 'FooterManager::updateQuickLinks');
    });

    // Catch-all route for admin
    $routes->add('(:any)', 'AdminController::$1');
});

// Public Routes
$routes->group('', function($routes) {
    // Container Routes
    $routes->get('container/(:segment)', 'ContainerController::view/$1');
    $routes->get('container/(:segment)/items/(:segment)', 'ContainerController::item/$1/$2');
    $routes->get('container/', 'ContainerController::index');
    
    // Gallery Routes
    $routes->get('gallery', 'GalleryController::index');
    $routes->get('gallery/(:segment)', 'GalleryController::index/$1');
    
    // Other Public Routes
    $routes->get('content/(:any)', 'Content::index');
    $routes->get('/', 'Home::index');
});

// Auto Routes
$routes->setAutoRoute(true);