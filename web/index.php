<?php
require_once '../vendor/autoload.php';
require_once '../config/app.php';

use App\Models\Router;
use App\Models\Request;

/**
 * First create router object with params Request object and default route
 */
$router = new Router(new Request, '/posts/index');

/**
 * Next declare the http methods
 */
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


/**
 * For RESTFul API
 */
$router->get('/api/v1/posts', function ($request) {
    header("Content-Type: application/json");
    $controller = new \App\Controllers\PostController($request);
    $result = $controller->indexJson();
    echo json_encode($result);;
});

$router->put('/api/v1/posts/:id', function ($request) {
    header("Content-Type: application/json");
    $controller = new \App\Controllers\PostController($request);
    $result = $controller->update();
    echo json_encode($result);
});

$router->delete('/api/v1/posts/:id', function ($request) {
    header("Content-Type: application/json");
    $controller = new \App\Controllers\PostController($request);
    $result = $controller->delete();
    echo json_encode($result);
});
