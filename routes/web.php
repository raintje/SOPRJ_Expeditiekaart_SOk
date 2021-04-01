<?php

use App\Http\Controllers\FirstLayerItemController;
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
    return view('home');
})->name("home");

Route::get('/layeritems', [FirstLayerItemController::class, 'all']);

Route::get('/items', [LayerItemController::class, 'index'])->name('items');
Route::post('/items', [LayerItemController::class, 'store'])->name('store.item');
Route::get('/items/create', [LayerItemController::class, 'create'])->name('create.item');
Route::get('/items/edit/location', [LayerItemController::class, 'editLocation'])->name('edit.item.location');
Route::post('/items/edit/location/save', [FirstLayerItemController::class, 'saveLocations'])->name('edit.item.location.save');
Route::get('/items/{id}', [LayerItemController::class, 'show'])->name('show.item');
Route::get('/items/{id}/edit', [LayerItemController::class, 'edit'])->name('edit.item');
Route::put('/items/{id}', [LayerItemController::class, 'update'])->name('update.item');
Route::get('/items/{id}/delete', [LayerItemController::class, 'destroy'])->name('destroy.item');

Auth::routes();

Route::get('/files/{id}', [LayerItemController::class, 'downloadFile'])->name('download.file');
