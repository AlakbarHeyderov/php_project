<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Auth\ApiAuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register',[ApiAuthController::class,'register']);
Route::post('/otp',[ApiAuthController::class,'otp']);
Route::post('/verification', [ApiAuthController::class, 'verification']);

Route::group(['middleware' => ['auth:api']], function (){
    Route::post('/insert/category',[CategoryController::class,'insert']);
    Route::get('/select/category',[CategoryController::class,'select']);
    Route::get('/delete/category',[CategoryController::class,'delete']);

    Route::post('/update/category',[CategoryController::class,'update']);

});
