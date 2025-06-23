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
$routes->get('/tiempos', 'Tiempos::index');
// En app/Config/Routes.php

$routes->group('catalogos', ['filter' => 'auth'], function($routes) {
    // La página principal de selección de catálogos
    $routes->get('/', 'Catalogos::index');
    
    // La página que muestra la lista de un catálogo específico
    $routes->get('list/(:segment)', 'Catalogos::list/$1');
    
    // Rutas para las acciones AJAX (Crear, Actualizar, Eliminar)
    $routes->post('create/(:segment)', 'Catalogos::create/$1');
    $routes->post('update/(:segment)/(:num)', 'Catalogos::update/$1/$2');
    $routes->post('delete/(:segment)/(:num)', 'Catalogos::delete/$1/$2');
});
$routes->get('/ajustes', 'Ajustes::index');
$routes->get('/ajustes/generales', 'Ajustes::generales');
$routes->get('/ajustes/usuarios', 'Ajustes::usuarios');
$routes->get('/ajustes/masterdata', 'Ajustes::masterData');