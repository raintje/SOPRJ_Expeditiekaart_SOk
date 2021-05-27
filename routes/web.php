<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FirstLayerItemController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemHistoryController;
use App\Http\Controllers\LayerItemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// HomeController routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// UserController routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('api/users', [UserController::class, 'getUsers'])->name('get.user');
    Route::put('/users/update/password/{user}', [UserController::class, 'updatePassword'])->name('user.update.password');
    Route::post('/users/delete', [UserController::class, 'destroy'])->name('destroy.user');
    Route::resource('users', UserController::class);

    //Item History
    Route::get('/items/restoreHistory/{id}', [ItemHistoryController::class, 'restoreItem'])->name('restore.item');
    Route::get('/items/deleteHistory/{id}', [ItemHistoryController::class, 'destroyHistoryEditOfItem'])->name('destroy.itemHistory');

    //Items
    Route::get('/items', [LayerItemController::class, 'index'])->name('items');
    Route::get('/items/create', [LayerItemController::class, 'create'])->name('create.item');
    Route::get('/items/{id}/edit', [LayerItemController::class, 'edit'])->name('edit.item');
    Route::post('/items/{id}', [LayerItemController::class, 'update'])->name('update.item');
    Route::post('/items', [LayerItemController::class, 'store'])->name('store.item');

    //Files
    Route::get('/items/{id}/delete', [LayerItemController::class, 'destroy'])->name('destroy.item');
    Route::get('/items/{id}/deleteFile/{fileId}', [LayerItemController::class, 'deleteLayerItemAppendix'])->name('delete.file');
    Route::get('/items/{id}/deleteLinkedFile/{linkId}', [LayerItemController::class, 'deleteLinkedLayerItem'])->name('delete.linkedFile');

    // DashboardController routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //FirstLayer
    Route::post('/items/edit/location/save', [FirstLayerItemController::class, 'saveLocations'])->name('edit.item.location.save');
    Route::get('/items/edit/location', [LayerItemController::class, 'editLocation'])->name('edit.item.location');

    // RoleController routes
    Route::resource('roles', RoleController::class);
});

// LayerItemController routes
Route::get('/items/{id}', [LayerItemController::class, 'show'])->name('show.item');

route::get('/items/{id}/breadcrumb/{breadcrumb}', [LayerItemController::class, 'show'])->name('breadcrumb.add');
route::get('/items/{id}/breadcrumb/{breadcrumb}/returnNr/{returnNr}', [LayerItemController::class, 'updateBreadcrumb'])->name('breadcrumb.update');


Route::get('/files/{id}', [LayerItemController::class, 'downloadFile'])->name('download.file');
Route::get('/files/{id}', [LayerItemController::class, 'downloadFile'])->name('download.file');

Route::get('api/items',[LayerItemController::class, 'getItems'])->name('get.item');

// FirstLayerItemController routes
Route::get('/layeritems', [FirstLayerItemController::class, 'all']);


// Auth routes
Auth::routes();
