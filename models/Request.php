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

    public function __construct()
    {
       $this->getRequestVars();
    }

    /**
     * Get all the vars from $_SERVER into local class vars
     */
    private function getRequestVars()
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
                return $this->getGetVars();
            case 'POST':
                return $this->getPostVars();

        }
    }

    private function getGetVars()
    {
        $get = [];
        foreach ($_GET as $key => $value) {
            $get[$key] =  filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $get;
    }

    private function getPostVars()
    {
        $post = [];
        foreach ($_POST as $key => $value) {
            $post[$key] =  filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $post;
    }

}
