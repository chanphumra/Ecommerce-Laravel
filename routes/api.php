<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MailController;
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
Route::apiResource('/category', CategoryController::class);

/*
|--------------------------------------------------------------------------
| Product API Routes
|--------------------------------------------------------------------------
*/
Route::apiResource('/product', ProductController::class);



Route::apiResource('/slideshow', SlideshowController::class);
