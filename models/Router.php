<?php
namespace App\Models;

use App\Models\Request;
use App\Models\IRequest;

class Router
{
    private $request;
    public $defaultRoute = null;
    public $defaultMethod = null;
    private $pathNotFound = true;
    private $allowedMethods = [ 'GET', 'POST'];

    public function __construct(IRequest $request, $defaultRoute)
    {
        $this->request = $request;
        $this->defaultRoute = $defaultRoute;

        if( ! in_array($request->requestMethod, $this->allowedMethods)) {
            header("{$this->request->serverProtocol} 405 Method Not Allowed");
            exit(1);
        }
    }

    public function get($route, $method)
    {
        $this->request->route = $route;
        $redirectUrl = isset($this->request->redirectUrl) ? $this->request->redirectUrl : null;
        // Make index optional
        if(substr($redirectUrl, -1) == '/') {
            $redirectUrl = $redirectUrl . 'index';
        }

        // Set Default Route's Method
        $this->defaultMethod = $this->defaultRoute === $route ? $method : $this->defaultMethod;

        if($route === $redirectUrl && $this->request->requestMethod === 'GET') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
        }
    }

    public function post($route, $method)
    {
        $this->request->route = $route;
        $redirectUrl = $this->request->redirectUrl;
        // Make index optional
        if(substr($this->request->redirectUrl, -1) == '/') {
            $redirectUrl = $redirectUrl . 'index';
        }

        if($route === $redirectUrl && $this->request->requestMethod === 'POST') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
        }
    }

    public function renderDefaultRoute()
    {
        if( ! is_null($this->defaultRoute) && is_callable($this->defaultMethod)) {
            return call_user_func_array($this->defaultMethod, [$this->request]);
        }

        return false;
    }

    public function __destruct()
    {
        if($this->pathNotFound) {
            $result = $this->renderDefaultRoute();
            if($result === false) {
                header("{$this->request->serverProtocol} 404 Not Found");
                echo 'Path not found';
            }
        }
    }

}
