<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/add-employee','EmployeeController::addEmployee');
$routes->get('/list-employee','EmployeeController::listEmployees');
$routes->get('/show-employee/(:num)','EmployeeController::showEmployee/$1');
$routes->put('/update-employee/(:num)','EmployeeController::updateEmployee/$1');
$routes->delete('/delete-employee/(:num)','EmployeeController::deleteEmployee/$1');

// $routes->group("api", function($routes){
//     $routes->get('/list-employee','EmployeeController::listEmployee');
//     $routes->get('/show-employee/(:num)','EmployeeController::showEmployee/$1');
//     $routes->put('/update-employee/(:num)','EmployeeController::updateEmployee/$1');
//     $routes->delete('/delete-employee/(:num)','EmployeeController::deleteEmployee/$1');
// });

// $routes->delete('/delete-employee/(:num)/(:num)','EmployeeController::deleteEmployee/$1/$2');
