<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TestMarzouk;
use App\Http\Controllers\PostsController;



Route::get('/authenticate', [PostsController::class,'get_authenticate']);  
Route::get('/checkAuth', [PostsController::class,'get_checkAuth']); 





// Route::get('/pos', function () {
//     return request()->header();
//     // return response()->json([
//     //     'title' => 'My first post',
//     //     'content' => 'This is my first post'
//     // ]);
// });
// Route::get('/postsmm', [PostsController::class,'index'])->middleware([TestMarzouk::class]);//on teste si middleware fonctionne
// Route::get('/postskk', [PostsController::class,'chekToken']);

// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth',
//     'namespace' => 'App\Http\Controllers'

// ], function ($router) {

//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });