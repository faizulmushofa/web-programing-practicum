<?php

namespace App\Config;

use PDO;

class Database {

    private static ?PDO $instance = null;
    private static string $dbFile = __DIR__ . '/../data.db';

    private function __construct(){}

    public static function getConnection() : PDO {
        if(self::$instance === null){
            self::$instance = new PDO("sqlite:" . self::$dbFile );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return self::$instance;
    }
}
