<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::show_login');
$routes->get('/dashboard', 'Dashboard::index');
$routes->post('/ingresar', 'Login::ingresar');
$routes->get('/registro', 'Registro::show_registro');
$routes->post('/registrar', 'Registro::guardar');
$routes->get('/login/captcha', 'Login::captcha');
$routes->get('/select-year', 'Dashboard::selectYear');
$routes->match(['get', 'post'], '/dashboard', 'Dashboard::index');
$routes->get('/ajustes', 'Ajustes::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/proyectos/nuevo', 'Projects::new'); 
$routes->post('/proyectos/crear', 'Projects::create');
$routes->get('/tareas', 'Tareas::index');
$routes->get('/recursos', 'Recursos::index');