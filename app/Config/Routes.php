<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Welcome::index');
$routes->get('tasks', 'Tasks::index');
$routes->get('profile', 'Profile::index');
$routes->get('about', 'Pages::about');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->get(
    'tasks/new',
    'TaskManager::createForm',
    ['filter' => 'auth']
);

$routes->post(
    'tasks/create',
    'TaskManager::create',
    ['filter' => 'auth']
);

$routes->get(
    'tasks/edit/(:num)',
    'TaskManager::edit/$1',
    ['filter' => 'auth']
);

$routes->post(
    'tasks/update/(:num)',
    'TaskManager::update/$1',
    ['filter' => 'auth']
);

$routes->post(
    'tasks/archive/(:num)',
    'TaskManager::archive/$1',
    ['filter' => 'auth']
);