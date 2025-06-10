<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SchedullingController;
use App\Http\Controllers\OrderController;

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


Route::post('/login', [AuthController::class, 'loginAction']);

Route::post('/store', [AuthController::class, 'store']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('/product')->middleware('auth:sanctum')->group(function()
{
    Route::get('/get', [ProductController::class, 'getProducts']);
    Route::get('/getMyProducts', [ProductController::class, 'getProductsById']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::post('/edit', [ProductController::class, 'edit']);
    Route::delete('/destroy', [ProductController::class, 'destroy']);
});
Route::prefix('/schedulling')->middleware('auth:sanctum')->group(function()
{
    Route::post('/get', [SchedullingController::class, 'getByProduct']);
    Route::post('/store', [SchedullingController::class, 'schedule']);
    Route::post('/accept', [SchedullingController::class, 'accept']);
    Route::post('/finish', [SchedullingController::class, 'finish']);
    Route::post('/destroy', [SchedullingController::class, 'destroy']);
});

Route::prefix('/order')->middleware('auth:sanctum')->group(function()
{
    Route::get('/getMyOrders', [OrderController::class, 'getMyOrders']);
    Route::post('/store', [OrderController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
