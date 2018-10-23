<?php

namespace App\Models;


class Post extends Model
{
    public $id;
    public $title;
    public $description;

    private $tableName = 'post';
    private $isNewRecord = null;

    /**
     * Post constructor.
     * @param null $id
     * @param null $title
     * @param null $description
     */
    public function __construct($id = null, $title = null, $description =null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Pass request object to this method to set the object attributes
     * @param IRequest $request
     */
    public function setAttributes(IRequest $request)
    {
        $attributes = $request->body();
        $this->id = isset($request->params['id'])  ? $request->params['id'] : null;
        $this->title = $attributes['title'];
        $this->description = $attributes['description'];
        $this->isNewRecord = true;
    }

    /**
     * These are the validation rules for the attributes
     * @return array
     */
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
        $rows = Database::connect()->selectAll($query, []);

        return $rows;
    }

    public function update()
    {
        $query = sprintf("UPDATE %s SET title=:title, description=:description WHERE id=:id", $this->tableName);
        $params = [':id'=>$this->id, ':title'=>$this->title, ':description'=>$this->description];
        $result = Database::connect()->update($query, $params);
        return $result;

    }

    public function delete()
    {
        $query = sprintf("DELETE FROM %s WHERE id=:id", $this->tableName);
        $params = [':id'=>$this->id];
        $result = Database::connect()->delete($query, $params);
        return $result;
    }

}
