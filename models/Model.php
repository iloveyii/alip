<?php
namespace App\Models;


/**
 * This is the parent model with common functionality for all child classes
 * Class Model
 *
 * @package App\Models
 */
abstract class Model
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @return array
     */
    abstract public function rules() : array ;

    /**
     * @return bool
     */
    public function validate() : bool
    {
        $validation = []; // contains all errors
        $rules = $this->rules(); // rules in the child class

        /**
         * Iterate over all rules
         * Rules has the form of object property => ruleArray : ie first loop
         * So we can get object property value by $this->{$property} : ie in second loop
         */
        foreach ($rules as $varName=>$ruleArray) {
            $varValue = $this->{$varName};

            foreach ($ruleArray as $key=>$ruleName) {

                if( ! isset($this->{$varName})) continue;

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
                    case 'alpha':
                        if( preg_match('/[0-9]/', $varValue) === 1) {
                            $validation[$varName][] = "{$varName} should contain only alphabets";
                        }
                        break;
                    case 'stripTags':
                        $this->{$varName} = strip_tags($varValue);
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

        $this->errors = $validation;

        return count($validation) === 0;
    }

    /**
     * Return the array or errors
     * @return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * Check if model has errors
     * @return bool
     */
    public function hasErrors() : bool
    {
        return count($this->errors) > 0;
    }
}
