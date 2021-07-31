<?php 
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

// Frontend Routes
$router->get('/', '\App\Controllers\PagesController@index');
$router->get('/about', '\App\Controllers\PagesController@about');
$router->get('/user/{id}', '\App\Controllers\PagesController@user');
$router->get('/users', '\App\Controllers\PagesController@users');


// Admin Routes
$router->get('/system-admin', '\Admin\Controllers\AdminsController@index');
$router->get('/system-admin/clients', '\Admin\Controllers\ClientsController@list');


$router->get('/system-admin/login', '\Admin\Controllers\LoginController@login');
$router->post('/system-admin/login/submit', '\Admin\Controllers\LoginController@login_submit');
$router->get('/system-admin/logout', '\Admin\Controllers\LoginController@logout');

$router->get('/system-admin/forgot-password', '\Admin\Controllers\LoginController@forgot_password');
$router->post('/system-admin/forgot-password/submit', '\Admin\Controllers\LoginController@forgot_password_submit');

$router->get('/system-admin/locations', '\Admin\Controllers\LocationsController@list');
$router->get('/system-admin/locations/ajax_get_all', '\Admin\Controllers\LocationsController@ajax_get_all');
$router->get('/system-admin/locations/create', '\Admin\Controllers\LocationsController@create');
$router->post('/system-admin/locations/create/save', '\Admin\Controllers\LocationsController@create_save');
$router->get('/system-admin/locations/update/{id}', '\Admin\Controllers\LocationsController@update');
$router->post('/system-admin/locations/update/save', '\Admin\Controllers\LocationsController@update_save');
$router->post('/system-admin/locations/delete', '\Admin\Controllers\LocationsController@delete');

$router->get('/system-admin/admins', '\Admin\Controllers\AdminsController@list');
$router->get('/system-admin/admins/ajax_get_all', '\Admin\Controllers\AdminsController@ajax_get_all');
$router->get('/system-admin/admins/create', '\Admin\Controllers\AdminsController@create');
$router->post('/system-admin/admins/create/save', '\Admin\Controllers\AdminsController@create_save');
$router->get('/system-admin/admins/update/{id}', '\Admin\Controllers\AdminsController@update');
$router->post('/system-admin/admins/update/save', '\Admin\Controllers\AdminsController@update_save');
$router->post('/system-admin/admins/delete', '\Admin\Controllers\AdminsController@delete');


$router->get('/system-admin/jobs-by-email', '\Admin\Controllers\JobsController@list');
$router->get('/system-admin/banners', '\Admin\Controllers\BannersController@list');
$router->get('/system-admin/logos', '\Admin\Controllers\LogosController@list');
$router->get('/system-admin/mass-mailer', '\Admin\Controllers\MailerController@list');
$router->get('/system-admin/agencies', '\Admin\Controllers\AgenciesController@list');
$router->get('/system-admin/admin-users', '\Admin\Controllers\AdminsController@list');


// Set 404 route last
$router->set404('PagesController@page_404');

$router->run();