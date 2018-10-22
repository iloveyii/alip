<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use App\Models\Router;
use App\Models\Request;

$request = new Request();
$request->setRequestMethod('POST'); // test methods
$router = new Router($request);

$router->get('/posts/index', function ($request) {
    $controller = new \App\Controllers\PostController($request);
    $controller->index();
});


$router->get('/posts/create', function ( \App\Models\IRequest $request) {
    $request->setGetVars(['id'=>'gg', 'title'=>'this', 'description'=> 'this is desc']); // test
    $request->setPostVars(['id'=>'gg', 'title'=>'this', 'description'=> 'this is desc']); // test

    $controller = new \App\Controllers\PostController($request);
    $controller->create();
});

$router->post('/posts/create', function ( \App\Models\IRequest $request) {
    $request->setGetVars(['id'=>'gg', 'title'=>'this', 'description'=> 'this is desc']); // test
    $request->setPostVars(['id'=>'gg', 'title'=>'this', 'description'=> 'this is desc']); // test

    $controller = new \App\Controllers\PostController($request);
    $controller->create();
});


//$router->get('/api/v1/posts', function ($request) {
//    $songs = [
//        [
//            'artist' => "Some Singer",
//            'author' => "Some Lover",
//            'filename' => "horse.ogg",
//            'id'=> 1,
//            'title' => "A lovely song"
//        ],
//        [
//            'artist' => "Some Singer 2 ",
//            'author' => "Some Lover 2",
//            'filename' => "horse.ogg 2",
//            'id'=> 2 ,
//            'title' => "A lovely song 2"
//        ],
//    ];
//
//    echo json_encode($songs);
//});
