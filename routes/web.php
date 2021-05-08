<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FirstLayerItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayerItemController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// HomeController routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// UserController routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('api/users', [UserController::class, 'getUsers'])->name('get.user');
    Route::get('/users/create', [UserController::class, 'create'])->name('create.user');
    Route::put('/users/update/password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
    Route::post('/users', [UserController::class, 'store'])->name('store.user');
    Route::post('/users/delete', [UserController::class, 'destroy'])->name('destroy.user');
});

// DashboardController routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// LayerItemController routes
Route::get('/items', [LayerItemController::class, 'index'])->name('items');
Route::get('/items/create', [LayerItemController::class, 'create'])->name('create.item');
Route::get('/items/{id}', [LayerItemController::class, 'show'])->name('show.item');
Route::get('/items/{id}/edit', [LayerItemController::class, 'edit'])->name('edit.item');
Route::post('/items/{id}', [LayerItemController::class, 'update'])->name('update.item');

route::get('/items/{id}/breadcrumb/{breadcrumb}', [LayerItemController::class, 'show'])->name('breadcrumb.add');
route::get('/items/{id}/breadcrumb/{breadcrumb}/returnNr/{returnNr}', [LayerItemController::class, 'updateBreadcrumb'])->name('breadcrumb.update');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/items/{id}/deleteFile/{fileId}', [LayerItemController::class, 'deleteLayerItemAppendix'])->name('delete.file');
Route::get('/items/{id}/deleteLinkedFile/{linkId}', [LayerItemController::class, 'deleteLinkedLayerItem'])->name('delete.linkedFile');
Route::get('/files/{id}', [LayerItemController::class, 'downloadFile'])->name('download.file');
Route::get('/items/{id}/delete', [LayerItemController::class, 'destroy'])->name('destroy.item');
Route::get('/files/{id}', [LayerItemController::class, 'downloadFile'])->name('download.file');
Route::get('/items/edit/location', [LayerItemController::class, 'editLocation'])->name('edit.item.location');


Route::get('api/items',[LayerItemController::class, 'getItems'])->name('get.item');
Route::post('/items/{id}', [LayerItemController::class, 'update'])->name('update.item');
Route::post('/items', [LayerItemController::class, 'store'])->name('store.item');

// FirstLayerItemController routes
Route::get('/layeritems', [FirstLayerItemController::class, 'all']);
Route::post('/items/edit/location/save', [FirstLayerItemController::class, 'saveLocations'])->name('edit.item.location.save');

// Auth routes
Auth::routes();
