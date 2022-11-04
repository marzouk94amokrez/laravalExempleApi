<?php
namespace App\Classes;

use PDO;
use PDOException;

class Connection {

    private static $instanceDB = null;

    public static function getPDO () : PDO {
        if(is_null(self::$instanceDB)){
            try{
                self::$instanceDB = new PDO("mysql:host=localhost;dbname=transdev;charset=utf8", 'root', 'root', [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ]);
            } catch (PDOException $e){
                die('*** FATAL *** ERROR ** Impossible de se connecter à la base de donnée (PDO). ' . $e->getMessage() );
            }
            
        }
        return self::$instanceDB; 
    }
    
}
