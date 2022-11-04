<?php 
namespace App\Classes;

use Exception;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;

class JwtController {
    public static function generateToken ($email, $type,$level) : array {
        $secret_key = "YOUR_SECRET_KEY";
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 360000; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array( 
                "email" =>  $email,
                "type" => $type,
                "level" => $level,
                
        ));
        return [JWT::encode($token, $secret_key,'HS256'), $expire_claim];
    }
    public static function decodingToken($token) {
        
        JWT::$leeway += 10;
        $decoded = JWT::decode($token, new Key("YOUR_SECRET_KEY", 'HS256'));
        $data = $decoded->data;
        return $data;
    }

    public static function getAuthHeader () {
        $header = '';
        if (isset($_SERVER['HTTP_AUTHORIZATION']) && !is_null($_SERVER['HTTP_AUTHORIZATION'])){
            $header = $_SERVER['HTTP_AUTHORIZATION'];
        }else if(isset($_SERVER['SERVER_SOFTWARE']) && !is_null($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false) {  
            $moreApacheHeaders = apache_request_headers(); 
            if (isset($moreApacheHeaders['Authorization']) && !is_null($moreApacheHeaders['Authorization'])){  
                $header = $moreApacheHeaders['Authorization'];
            } else if (isset($moreApacheHeaders['authorization']) && !is_null($moreApacheHeaders['authorization'])){ 
                $header = $moreApacheHeaders['authorization'];
            }

        }   
        return $header;
        
    }

    public static function b64Decode (string $header) {
        $decode = base64_decode($header);
        [$login, $pwd] = explode(':', $decode);
        return [$login, $pwd];
    }

    public static function checkAuth () {
        $header = JwtController::getAuthHeader();
        [$bearer, $token] = explode(" ", $header);
        try{
            JWT::$leeway += 10;
            $decoded = JWT::decode($token, new Key("YOUR_SECRET_KEY", 'HS256'));
            
            return true;
        }catch (Exception $e) {
            response()->json(array(
                "message" => "Access denied",
                "error" => $e->getMessage()
            ), 401);
        }
        
    }
}