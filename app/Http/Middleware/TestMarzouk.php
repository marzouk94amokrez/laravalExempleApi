<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TestMarzouk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tok=($request->header('token'));
  
        if ($tok!=="12345678") {
         
            return response()->json(['error' => 'yess marzouk'], 401);
       
            
        }else{
                 return $next($request);
        }
    
   }
}