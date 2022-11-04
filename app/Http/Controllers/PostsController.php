<?php
namespace App\Http\Controllers;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Classes\JwtController;
use App\Classes\Helper;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function get_authenticate(Request $request) {
        $header = JwtController::getAuthHeader();
        [$type, $value] = explode(' ', $header);    
      //  [$email, $pwd] = JwtController::b64Decode($value);
        $user = Helper::findByLogin($value);
         var_dump( $user);
         die();
         $user = (object)array('id'=>1,'level'=>'standard','type'=>'admin','login'=>'marzouksaibi@gmail.com');
     
        if($user && isset($user->id)){
            [$token, $expireIn] = JwtController::generateToken( "saibi@gmail.com", "type","level");
            $data = array(
                "message" => "Successful login.",
                "token" => $token,
                "email" =>  $user->login,
                "expireIn" => $expireIn,
                "type" => $user->type,
                "level" => $user->level,
                "code"=>200
            );
            $code = 200;
        } else {
                $code = 401;
                $data = array(
                        "message" => "userNotExist","code"=>$code
                        );
        }
        return response()->json($data, $code);
    }

    public function get_checkAuth(Request $request) {
        $header = JwtController::getAuthHeader();
        [$bearer, $token] = explode(' ', $header);   
        try{
            $data = JwtController::decodingToken($token);
            return response()->json([
                "success" => true,
                    "token" => $token,
                    "email" => $data->email,
                    "type" => $data->type,
                    "level" => $data->level,
            ]);
        }catch(Exception $e){
            return response()->json(array(
                "message" => "Access denied",
                "error" => $e->getMessage()
            ), 401);
        }
    }
  
}