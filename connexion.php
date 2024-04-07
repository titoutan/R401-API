<?php

class Connexion {
    private static $host = "mysql-a4cabinetapi.alwaysdata.net";
    private static $username = "350742";
    private static $password = '$iutinfo';
    private static $database = "a4cabinetapi_cabinet";
    private static $port = "3306";
    private static $_instance = null;
    private PDO $linkpdo;

    private function __construct() {
        try {
            $this->linkpdo = new PDO(sprintf('mysql:host=%s;port=%s;dbname=%s',self::$host, self::$port, self::$database), self::$username, self::$password);
            }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        return self::$_instance ?? self::$_instance = new Connexion();
    }

    public function getPDO() : PDO {
        return $this->linkpdo;
    }
}