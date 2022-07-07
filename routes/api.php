<?php

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



Route::group(['prefix' => 'tenants', 'as' => 'api.'], function() {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class,'login']);
    Route::post('register', [App\Http\Controllers\Api\UsersController::class,'store']);
    
    Route::group(["middleware" => ["auth:user_api"]], function(){
        Route::post('logout', [App\Http\Controllers\Api\AuthController::class,'logout']);
        Route::get('user', [App\Http\Controllers\Api\AuthController::class,'user']);
        Route::post('add-user-tenant', [App\Http\Controllers\Api\UsersController::class,'addTenant']);
        Route::post('remove-user-tenant', [App\Http\Controllers\Api\UsersController::class,'removeTenant']);
        Route::get('tenants', [App\Http\Controllers\Api\TenantsController::class,'index']);
        
        Route::resource('users', App\Http\Controllers\Api\UsersController::class); 
        Route::resource('products', App\Http\Controllers\Api\ProductsController::class); 
    });
});


Route::group(['prefix' => 'admin', 'as' => 'api.'], function() {
    
    Route::post('login', [App\Http\Controllers\Api\AuthController::class,'adminLogin']);
    
    Route::group(["middleware" => ["auth:admin_api"]], function(){
        Route::get('user', [App\Http\Controllers\Api\AuthController::class,'admin']);
        Route::resource('tenants', App\Http\Controllers\Api\TenantsController::class); 
    });
});