<?php
namespace App\Models;

class Router
{
    private $request;
    public $defaultRoute = null;
    public $defaultMethod = null;
    private $pathNotFound = true;
    private $allowedMethods = [ 'GET', 'POST', 'PUT', 'DELETE'];

    public function __construct(IRequest $request, $defaultRoute)
    {
        $this->request = $request;
        $this->defaultRoute = $defaultRoute;

        if( ! in_array($request->requestMethod, $this->allowedMethods)) {
            header("{$this->request->serverProtocol} 405 Method Not Allowed, allowed methods are ", implode(', ', $this->allowedMethods));
            exit(1);
        }
    }

    public function get($route, $method)
    {
        $this->request->route = $route;
        $redirectUrl = isset($this->request->redirectUrl) ? $this->request->redirectUrl : null;
        // Make index optional
        if(substr($redirectUrl, -1) === '/') {
            $redirectUrl = $redirectUrl . 'index';
        }

        // Set Default Route's Method
        $this->defaultMethod = $this->defaultRoute === $route ? $method : $this->defaultMethod;

        if($route === $redirectUrl && $this->request->requestMethod === 'GET') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
            Log::write('Found route ' . $route, INFO);
            exit(0);
        }
    }

    public function post($route, $method)
    {
        $this->request->route = $route;
        $redirectUrl = $this->request->redirectUrl;
        // Make index optional
        if(substr($this->request->redirectUrl, -1) === '/') {
            $redirectUrl = $redirectUrl . 'index';
        }

        if($route === $redirectUrl && $this->request->requestMethod === 'POST') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
            exit(0);
        }
    }

    /**
     * Note: works for one param only
     * @param $route
     */
    private function getParams($route)
    {
        // Split out id part
        $redirectUrl = $this->request->redirectUrl;
        $routeArray = explode(':', $route);
        $varsArray = [];

        if(count($routeArray) > 1) {
            $route = array_shift($routeArray);
            foreach ($routeArray as $varName) {
                $varsArray[$varName] = str_replace($route, '', $redirectUrl);
            }
            $this->request->params = $varsArray;
        }
    }


    public function put($route, $method)
    {
        $this->request->route = $route;
        $this->getParams($route);

        if($this->request->requestMethod === 'PUT') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
            exit(0);
        }
    }

    public function delete($route, $method)
    {
        $this->request->route = $route;
        $this->getParams($route);

        if($this->request->requestMethod === 'DELETE') {
            $this->pathNotFound = false;
            call_user_func_array($method, [$this->request]);
            exit(0);
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
