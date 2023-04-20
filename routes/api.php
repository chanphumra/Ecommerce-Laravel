<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/category', [CategoryController::class, 'store']);
    Route::put('/category/{category}', [CategoryController::class, 'update']);
    Route::delete('/category/{category}', [CategoryController::class, 'destroy']);

    Route::post('/product', [ProductController::class, 'store']);
    Route::put('/product/{product}', [ProductController::class, 'update']);
    Route::delete('/product/{product}', [ProductController::class, 'destroy']);
    Route::put('/product/clearStock/{product}', [ProductController::class, 'clearStock']);
});

/*
|--------------------------------------------------------------------------
| AUth API Routes
|--------------------------------------------------------------------------
*/
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/auth/exist', [AuthController::class, 'exist']);
Route::post('/auth/verify', [AuthController::class, 'verify']);

/*
|--------------------------------------------------------------------------
| Email API Routes
|--------------------------------------------------------------------------
*/
Route::post('/sendEmail', [MailController::class, 'sendEmail']);
Route::post('/storeOTP', [MailController::class, 'storeOTP']);
Route::delete('/deleteOTP/{email}', [MailController::class, 'deleteOTP']);

/*
|--------------------------------------------------------------------------
| Category API Routes
|--------------------------------------------------------------------------
*/
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{category}', [CategoryController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
*/
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{product}', [ProductController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Order API Routes
|--------------------------------------------------------------------------
*/
Route::get('/order', [OrderController::class, 'index']);
Route::get('/order/{order}', [OrderController::class, 'show']);
Route::post('/order/store', [OrderController::class, 'store']);
Route::post('/order/storeDetail', [OrderController::class, 'storeDetail']);
