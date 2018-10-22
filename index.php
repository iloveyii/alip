<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use App\Models\Router;
use App\Models\Request;


$router = new Router(new Request);

$router->get('/posts/index', function ($request) {
    echo 'index of posts';
});


$router->get('/posts/create', function ($request) {
    echo 'create a new post: ';
});
