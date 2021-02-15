<?php

namespace App;

use \PDO;
use \PDOException;

class ConnectionFactory
{
    static $db = null;
    private $pdo;
    static $connection;

    static function makeConnection(array $conf)
    {
        $host=$conf['host'];
        $dbname=$conf['dbname'];
        $login=$conf['login'];
        $password=$conf['password'];
        
        try{
            self::$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $login, $password);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$db->setAttribute(PDO::ATTR_PERSISTENT, true);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            self::$db->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return self::$db;
    }

    static function getConnection($conf = null)
    {
        if (!self::$db) {
            self::$db = ConnectionFactory::makeConnection($conf);
        }

        return self::$db;
    }
}
