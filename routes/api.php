<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::resource('sale', App\Http\Controllers\SaleController::class)->only(['index','store','show','update','destroy']);

Route::resource('product', App\Http\Controllers\ProductController::class)->only(['index','store','show','update','destroy']);

Route::post('product/search', [ProductController::class, 'search'])->name('product.search');

Route::get('product/{name}/{value}', [ProductController::class, 'search2'])->name('product.search2');