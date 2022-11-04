<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Exception;
use Firebase\JWT\Key;
use \Firebase\JWT\JWT;
use App\Classes\JwtController;
use App\Classes\Connection;
        // header("Access-Control-Allow-Origin: *");
        // header("Content-Type: application/json; charset=UTF-8");
        // header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        // header("Access-Control-Max-Age: 3600");
        // header("Access-Control-Expose-Headers:*");
        // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, authorization, Content-Disposition");
class AuthentificationCheked
{
    public function __construct()
    {
        $this->pdo = Connection::getPDO();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    private $method;
    private $controller;
    private $id;
    private $pdo;
    private $headerAuth;
    private $query = null;
    private $httpMethod;
   
    public function handle(Request $request, Closure $next)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->httpMethod = $requestMethod;
        $initialUri = $_SERVER['REQUEST_URI'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $pp= $_SERVER['HTTP_AUTHORIZATION'];
        if ($this->httpMethod == 'OPTIONS'){
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods:GET,PUT, POST, DELETE, OPTIONS");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            http_response_code(200);
            die();
        }
        try{

            if($initialUri=="/api/authenticate"||JwtController::checkAuth()){
                return $next($request);
            }
        }catch(Exception $e){
            return response()->json(array(
                "message" => "hhfghfghrfthft",
                "error" => $e->getMessage()
            ), 401);
        }

      
   }
//    public function validate(){
//     try{
//         $var=$_SERVER['HTTP_AUTHORIZATION'];
//         $decoded = JWT::decode($var, new Key("YOUR_SECRET_KEY", 'HS256'));
//         return true;
//     }catch (Exception $e) {
//       response()->json(array(
//             "message" => "Access denied",
//             "error" => $e->getMessage()
//         ), 401);
//     }
//    }




}