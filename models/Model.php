<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-10-22
 * Time: 17:46
 */

namespace App\Models;


class Model
{
    private $errors = [];

    public function validate()
    {
        $validation = [];

        $rules = $this->rules();

        foreach ($rules as $varName=>$ruleArray) {
            foreach ($ruleArray as $key=>$ruleName) {
                $varValue = $this->{$varName};
                switch ($ruleName) {
                    case 'integer':
                        if( isset($varValue) && ! is_numeric($varValue) ) {
                            $validation[$varName][] = "{$varName} must be an integer";
                        }
                        break;

                    case 'string':
                        if( ! is_string($varValue) && is_numeric($this->{$varName}) ) {
                            $validation[$varName][] = "{$varName} must be an integer";
                        }
                        break;

                    case 'required':
                        if( ! isset($varValue)) {
                            $validation[$varName][] = "{$varName} is required";
                        }
                        break;
                }

                switch ($key) {
                    case 'minLength':
                        if(strlen($varValue) < $ruleName) {
                            $validation[$varName][] = "{$varName} min length is {$ruleName}";
                        }
                        break;

                    case 'maxLength':
                        if(strlen($varValue) > $ruleName) {
                            $validation[$varName][] = "{$varName} max length is {$ruleName}";
                        }
                        break;
                }
            }
        }

        print_r($validation);
        return count($validation) === 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }
}
