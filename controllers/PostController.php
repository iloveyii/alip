<?php
require __DIR__ . '/../vendor/autoload.php';

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
        $this->render('index', $posts = []);
    }

    public function render($view, $params)
    {

    }
}
