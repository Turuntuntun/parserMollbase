<?php

namespace application\lib;

use PDO;
class Db
{
    protected $db;
    function __construct()
    {
        $config = require 'application/configs/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['dbname'],$config['user'],$config['password']);
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(':'.$key,$value);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql,$params = [])
    {
        $result = $this->query($sql,$params);
        return $result->fetchAll(PDO::FETCH_ASSOC);

    }
    public function column($sql,$params = [])
    {
        $result = $this->query($sql,$params);
        return $result->fetchColumn();
    }

    public function insert($sql,$params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(':'.$key,$value);
            }
        }
        $stmt->execute();
    }
}