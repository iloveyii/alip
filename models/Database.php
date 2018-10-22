<?php

namespace App\Models;

class Database
{

    private static $instance;
    public $db;
    public $numRows;
    public $lastId;

    public static function connect()
    {
        $db = null;

        if( isset(self::$instance) ) {
            return self::$instance;
        }

        try
        {
            $connectionString =  sprintf("mysql:host=%s;dbname=%s;charset=utf8;", DB_HOST, DB_NAME);
            $db = new \PDO($connectionString, DB_USER, DB_PASS);
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch (exception $e)
        {
            throw new Exception($e->getMessage());
        }

        self::$instance = new self();
        self::$instance->db = $db;

        return self::$instance;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function selectAll($query, $params)
    {
        $sth = $this->db->prepare($query);
        $sth->execute($params);
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->lastId = $this->db->lastInsertId();
        $this->numRows = count($result) - 1;
        return $result;
    }

    public function selectOne($query, $params)
    {
        $sth = $this->db->prepare($query);
        $sth->execute($params);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $this->lastId = $this->db->lastInsertId();
        $this->numRows = count( (array)$result);
        return $result;
    }

    public function delete($query, $params)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
    }

    public function update($query, $params)
    {
        $stmt = $this->db->prepare($query);
        $num = $stmt->execute($params);
        $this->numRows = $num;
        return $num;
    }

    public function insert($query, $params=[])
    {
        self::connect();

        try
        {
            $sth = $this->db->prepare($query);
            $sth->execute($params);
            $this->lastId = $this->db->lastInsertId();
            return $this->lastId;
        }
        catch(PDOException $e)
        {
            throw new Exception($e->getMessage() + $query);
        }
        catch( Exception $e)
        {
            throw new Exception($e->getMessage() + $query);
        }
    }

}

