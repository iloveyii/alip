<?php

namespace App\Models;

use App\Models\Database;

class Post extends Model
{
    public $id;
    public $title;
    public $description;

    private $tableName = 'post';
    private $isNewRecord = null;

    public function __construct($id = null, $title = null, $description =null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function setAttributes(IRequest $request)
    {
        $attributes = $request->body();
        $this->id = isset($attributes['id']) ? $attributes['id'] : null;
        $this->title = $attributes['title'];
        $this->description = $attributes['description'];
        $this->isNewRecord = true;
    }

    public function rules()
    {
        return [
            'id' => ['integer'],
            'title' => ['string', 'minLength'=>5, 'maxLength'=>40],
            'description' => ['string', 'minLength'=>15, 'maxLength'=>300],
        ];
    }

    // CRUD
    public function create()
    {
        $query = sprintf("INSERT INTO %s (title, description) VALUES (:title, :description)", $this->tableName);
        $params = [':title'=>$this->title, ':description'=>$this->description];
        return Database::connect()->insert($query, $params);
    }

    public function readAll()
    {
        $query = sprintf("SELECT id, title, description AS author, title AS filename, title AS artist FROM %s", $this->tableName);
        $params = [':title'=>$this->title, ':description'=>$this->description];
        $rows = Database::connect()->selectAll($query, []);

        return $rows;
    }

    public function read()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

}
