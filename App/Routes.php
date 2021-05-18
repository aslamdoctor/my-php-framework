<?php 
declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';

$router = new \Bramus\Router\Router();

$router->setNamespace('\App\Controllers');
$router->get('/', 'PagesController@index');
$router->get('/about', 'PagesController@about');
$router->get('/user/{id}', 'PagesController@user');
$router->get('/users', 'PagesController@users');

$router->set404('PagesController@page_404');

$router->run();