<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN
$routes->get('/', 'MerchantApp\LoginController::index');
$routes->post('/reqLogin', 'MerchantApp\LoginController::reqLogin');


// DASHBOARD
$routes->get('/getProfile', 'MerchantApp\DashboardController::getProfile');
$routes->get('/getCategory', 'MerchantApp\DashboardController::getCategory');
$routes->get('/menu', 'MerchantApp\DashboardController::index');
$routes->get('/getMenu', 'MerchantApp\DashboardController::getMenu');
$routes->post('/addMenu', 'MerchantApp\DashboardController::addMenu');
$routes->post('/updateMenu', 'MerchantApp\DashboardController::updateMenu');
$routes->delete('/deleteMenu', 'MerchantApp\DashboardController::deleteMenu');
