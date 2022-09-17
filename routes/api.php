<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TagsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AdsController;

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

$crudMethods = ['index', 'store', 'show', 'update', 'destroy'];

Route::resource('tags', TagsController::class)->only($crudMethods);

Route::resource('categories', CategoriesController::class)->only($crudMethods);

Route::get('ads', [AdsController::class, 'filter'])->name("ads.filter");
Route::get('advertiser/{id}/ads', [AdsController::class, 'adsByAdvertiser'])->name("advertiser.ads");
