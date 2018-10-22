<?php
require_once 'vendor/autoload.php';
require_once 'config/db.php';

use App\Models\Router;
use App\Models\Request;

$router = new Router(new Request);

$router->get('/posts/index', function ($request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->index();
});

$router->get('/posts/create', function ( \App\Models\IRequest $request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->create();
});

$router->post('/posts/create', function ( \App\Models\IRequest $request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->create();
});

$router->get('/api/v1/posts', function ($request) {
    $controller = new \App\Controllers\PostController($request);
    $result = $controller->indexJson();
    echo $result;
});
