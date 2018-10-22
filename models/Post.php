<?php

namespace App\Models;


class Post
{
    public $id;
    public $title;
    public $description;

    public function __construct($id, $title, $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function validate()
    {
        $validation = [];

        $rules = $this->rules();

        foreach ($rules as $varName=>$ruleArray) {
            foreach ($ruleArray as $key=>$ruleName) {
                $varValue = $this->{$varName};
                switch ($ruleName) {
                    case 'integer':
                        if( ! is_numeric($varValue) ) {
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

        return $validation;
    }

    public function rules()
    {
        return [
            'id' => ['integer', 'required'],
            'title' => ['string', 'minLength'=>5, 'maxLength'=>30],
            'description' => ['string', 'minLength'=>15, 'maxLength'=>300],
        ];
    }
}
