<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/layeritems', [FirstLayerItemController::class, 'all']);
Route::get('/items', [LayerItemController::class, 'index']);
Route::post('/items', [LayerItemController::class, 'store']);
Route::get('/items/create', [LayerItemController::class, 'create']);
Route::get('/items/{id}', [LayerItemController::class, 'show']);
Route::get('/items/{id}/edit', [LayerItemController::class, 'edit']);
Route::put('/items/{id}', [LayerItemController::class, 'update']);
