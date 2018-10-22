<?php
namespace App\Controllers;

use App\models;


class PostController
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function index()
    {
        $this->render('index', $posts = [1,2,3]);
    }

    public function create()
    {
        $post = new \App\Models\Post();
        $post->setAttributes($this->request);
        print_r($post->validate());
        $this->render('create', $posts = [1,2,3]);
    }

    public function render($view, $params)
    {
        $path = explode('\\', __CLASS__);
        $className = array_pop($path);
        $prefix = strtolower( str_replace('Controller', '', $className) );
        $content = print_r($params, true);
        require_once "views/{$prefix}/{$view}.php";
    }
}
