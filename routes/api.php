<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PermissionController;

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
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'admin']], function() {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'admin'], function(){
        Route::get('/', [ProductController::class, 'index']);
        Route::get('/products/delete', [ProductController::class, 'del']);
        
        Route::resource('products', ProductController::class)->only(['index', 'show', 'create', 'edit']);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });
});
