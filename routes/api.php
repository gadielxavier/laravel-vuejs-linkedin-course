<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/categories/upsert', [CategoryController::class, 'upsert']);

Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

Route::post('/menu-items/add', [MenuItemController::class, 'store']);

Route::get('/menu-items/{menuItem}', function (MenuItem $menuItem) {
    return $menuItem;
});

Route::post('/menu-items/{menuItem}', [MenuItemController::class, 'update']);

Route::post('/add-image', function (Request $request){
    //dd($request->images[0]['pathname']);
    $file = $request->images[0];
    $dir = 'public/images';
    $path = $file->store($dir);
    return str_replace("$dir/", '', $path);
});

Route::get('/categories/{category}/items', [CategoryController::class, 'items']);
