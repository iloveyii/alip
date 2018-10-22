<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-10-22
 * Time: 12:05
 */

namespace App\Models;


class Request implements IRequest
{
    public $route = null;
    public $getVars = [];
    public $postVars = [];

    public function __construct()
    {
       $this->bootStrap();
    }

    /**
     * Get all the vars from $_SERVER into local class vars
     */
    private function bootStrap()
    {
        foreach ($_SERVER as $key=>$value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    /**
     * Converts the vars in $_SERVER to camelCase
     * @param $value
     * @return mixed|string
     */
    private function toCamelCase($value)
    {
        $lower = strtolower($value);
        $parts = explode('_', $lower);
        $variableName = array_shift($parts);
        $camelParts = array_map(function ($v) {
            return ucfirst($v);
        }, $parts);
        $variableName = $variableName . implode('', $camelParts);
        return $variableName;
    }

    public function body()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $this->getVars = empty($this->getVars) ?  $_GET : $this->getVars; // for testing override real vars by setted vars
                return $this->getGetVars();
            case 'POST':
                $this->postVars = empty($this->postVars) ? $_POST : $this->postVars; // for testing override real vars by setted vars
                return $this->getPostVars();

        }
    }

    /**
     * For testing set post vars and this will override the real $_POST vars
     * @param array $post
     */
    public function setPostVars($post)
    {
        $this->postVars = $post;
    }

    /**
     * For testing set get vars and this will override the real $_GET vars
     * @param array $get
     */
    public function setGetVars($get)
    {
        $this->getVars = $get;
    }

    /**
     * For testing set the request method to desired one
     * @param $method
     */
    public function setRequestMethod($method)
    {
        $this->requestMethod = $method;
    }

    private function getGetVars()
    {
        $get = [];
        foreach ($this->getVars as $key => $value) {
            $get[$key] = $value; //  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $get;
    }

    private function getPostVars()
    {
        $post = [];
        foreach ($this->postVars as $key => $value) {
            $post[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $post;
    }

}
