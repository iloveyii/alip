<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use App\Models\Router;
use App\Models\Request;


$router = new Router(new Request);

$router->get('/posts/index', function ($request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->index();
});


$router->get('/posts/create', function ($request) {
//    $controller = new \App\Controllers\PostController($request);
//    $controller->create();
    $post = new \App\Models\Post(null, 'my title', 'my description this is a smart des and longer than 15 chars');
    print_r($post->validate());

});


$router->get('/api/v1/posts', function ($request) {
    $songs = [
        [
            'artist' => "Some Singer",
            'author' => "Some Lover",
            'filename' => "horse.ogg",
            'id'=> 1,
            'title' => "A lovely song"
        ],
        [
            'artist' => "Some Singer 2 ",
            'author' => "Some Lover 2",
            'filename' => "horse.ogg 2",
            'id'=> 2 ,
            'title' => "A lovely song 2"
        ],
    ];

    echo json_encode($songs);
});
