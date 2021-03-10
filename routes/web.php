<?php

use App\Http\Controllers\LayerItemController;
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
    return view('welcome');
});

Route::get('/items', [LayerItemController::class, 'index']);
Route::get('/items/{id}', [LayerItemController::class, 'show']);
Route::get('/items/create', [LayerItemController::class, 'create']);
Route::get('/items/edit/{id}', [LayerItemController::class, 'edit']);
