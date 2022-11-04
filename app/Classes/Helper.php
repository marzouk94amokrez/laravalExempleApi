<?php 
namespace App\Classes;
use PDO;
use Exception;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class Helper {

   
    public static function findByLogin(string $login) {
        $pdo = Connection::getPDO(); 
        $query = $pdo->prepare('SELECT u.*, be.uid AS entityFirst,be.status, max(b.id), (SELECT count(eu.id) FROM bentityuser eu WHERE eu.child = u.id) > 1 AS multiEntities FROM buser u  
                                        JOIN bentityuser b  JOIN bentity be ON be.id=b.parent  ON b.child=u.id WHERE login = :login');
        $query->execute(['login' => $login]);
        $query->setFetchMode(PDO::FETCH_OBJ);
        $result = $query->fetch();
        return $result;
    }


   


}