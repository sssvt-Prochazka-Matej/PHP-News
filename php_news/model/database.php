<?php

class Database
{
    const HOST = 'localhost';
    const DBNAME = 'php_news_4b2';
    const USER = 'root';
    const PASSWORD = '';


    protected $conn;

    public function __construct()
    {
        $this->conn = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME, self::USER, self::PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $this->conn->query('SET NAMES utf8');
    }

    public function select($sql, $params = [])
    {
        $stmt = $this->execute($sql, $params);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = []){
        $stmt = $this->execute($sql,$params);
        return $stmt->fetch();
    }

    public function executeSql($sql, $params = []){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }

    protected function execute($sql, $params = []){
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}