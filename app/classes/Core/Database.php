<?php

namespace Core;

use \PDO;
use \PDOException;

class Database
{
    protected $con = null;
    public $has_error = false;
    public $error = '';

    public function __construct()
    {
        $str = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME;
        try {
            $con = new PDO($str, DB_USER, DB_PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->con = $con;
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }

    public function query(string $sql, array $data = [])
    {
        try {
            $this->has_error = false;
            $this->error = '';

            $stm = $this->con->prepare($sql);
            $stm->execute($data);
        } catch (PDOException $e) {
            $this->has_error = true;
            $this->error = $e->getMessage();
            return false;
        }
        return $stm;
    }

    public function fetch(string $table, array $data = [])
    {
        $sql = "select * from $table where id = :id";
        return $this->query($sql, $data)->fetch(PDO::FETCH_OBJ);
    }
    public function fetchByValue(string $table, array $data = [], string $where, string $mode = 'one')
    {
        $sql = "select * from $table where $where";
        if ($mode === 'all') {
            return $this->query($sql, $data)->fetchAll(PDO::FETCH_OBJ);
        } else {
            return $this->query($sql, $data)->fetch(PDO::FETCH_OBJ);
        }
    }

    public function fetchAll(string $table, array $data = [], int $limit = 10, int $offset = 0)
    {
        $sql = "select * from $table order by date_created desc limit $limit offset $offset";
        show($sql);
        return $this->query($sql, $data)->fetchAll(PDO::FETCH_OBJ);
    }

    public function count_data(string $table, array $data = [])
    {
        $sql = "select count(*) as total from $table";
        return $this->query($sql, $data)->fetch(PDO::FETCH_OBJ)->total;
    }
    public function insert(string $table, array $data)
    {
        $keys = array_keys($data);
        $sql = "insert into $table (" . implode(',', $keys) . ") values (:" . implode(',:', $keys) . ")";
        $this->query($sql, $data);
        return $this->con;
    }

    public function update(string $table, array $data, string $where, array $whereParams = [])
    {
        $str = '';
        foreach ($data as $key => $value) {
            $str .= $key . "=:" . $key . ",";
        }
        $str = trim($str, ',');

        $sql = "update $table set " . $str . " where $where";
        $arr = array_merge($data, $whereParams);
        return $this->query($sql, $arr)->rowCount();
    }

    public function delete(string $table, string $where, array $whereParams = [])
    {
        $sql = "delete from $table where $where";
        return $this->query($sql, $whereParams)->rowCount();
    }
}
