<?php

namespace Config;

use Config\Services;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Scales
$routes->get('/api/scales', 'Scales::getScalesAll');
$routes->post('/api/scales', 'Scales::insertScale');
$routes->put('/api/scales/', 'Scales::updateScaleByID');
$routes->put('/api/scales/on/(:num)', 'Scales::setScaleStateOnByID/$1');
$routes->put('/api/scales/off/(:num)', 'Scales::setScaleStateOffByID/$1');
$routes->get('/api/scales/(:any)/(:any)', 'Scales::getScaleByCustom/$1/$2');
$routes->get('/api/scales/(:num)', 'Scales::getScaleByID/$1');
$routes->delete('/api/scales/(:num)', 'Scales::deleteScaleByID/$1');

//Users
$routes->get('/api/users/', 'Users::getUsersAll');
$routes->post('/api/users/', 'Users::insertUser');
$routes->put('/api/users/', 'Users::updateUserByID');
$routes->get('/api/users/(:num)', 'Users::getUserByID/$1');
$routes->delete('/api/users/(:num)', 'Users::deleteUserByID/$1');

//Experiments 
$routes->get('/api/experiments/', 'Experiments::getExperimentsAll');
$routes->post('/api/experiments/', 'Experiments::insertExperiment');
$routes->put('/api/experiments/', 'Experiments::updateExperimentByID');
$routes->put('/api/experiments/doing/(:num)', 'Experiments::setExperimentsStateDoingByID/$1');
$routes->put('/api/experiments/finished/(:num)', 'Experiments::setExperimentsStateFinishedByID/$1');
$routes->get('/api/experiments/user/(:num)', 'Experiments::getExperimentsByUser/$1');
$routes->get('/api/experiments/(:num)', 'Experiments::getExperimentByID/$1');
$routes->delete('/api/experiments/(:num)', 'Experiments::deleteExperimentByID/$1');

//Records
$routes->get('/api/records/experiments/(:num)', 'Records::getRecordsByExperimentsID/$1');
$routes->get('/api/records/(:any)/(:any)/(:any)', 'Records::insertRecord/$1/$2/$3');

//Insert Record :device/:value/:timestamp

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
