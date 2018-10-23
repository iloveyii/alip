<?php
namespace App\Controllers;


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

        if($this->request->isPost()) {
            $post->setAttributes($this->request);
            if( $post->validate() && $post->create() ) {
                header("Location: /posts/index");
            }
        }

        $this->render('create', $post);
    }

    public function update()
    {
        $post = new \App\Models\Post();

        $post->setAttributes($this->request);
        if( $post->validate() && $post->update() ) {
            header("Location: /posts/index");
        }

        $this->render('create', $post);
    }

    public function render($view, $model)
    {
        $path = explode('\\', __CLASS__);
        $className = array_pop($path);
        $prefix = strtolower( str_replace('Controller', '', $className) );
        $dirPath = realpath(dirname(dirname(__FILE__)));
        require_once "$dirPath/views/{$prefix}/{$view}.php";
    }

    public function indexJson()
    {
        $post = new \App\Models\Post();
        $posts = $post->readAll();
        header("Content-Type: application/json");
        return json_encode($posts);
    }


}
