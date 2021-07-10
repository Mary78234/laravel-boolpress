<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function(){
    $data = [
        'nomi' => ['Gino', 'Pino', 'Tino'],
        'level' => 3,
        'isValid' => true
    ];
    return response()->json($data);
});

Route::namespace('Api')
    ->name('api.')
    ->group(function(){
        Route::get('posts', 'PostController@index')->name('posts');
        Route::get('posts/{slug}', 'PostController@show')->name('show');
    });