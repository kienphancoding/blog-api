<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/blogs')->group(function () {
    Route::get('/', [BlogController::class, "index"]); //2 tham số : count (số lượng blog) và page (trang thứ x)
    Route::get('/{path}', [BlogController::class, "show"]);
    Route::get('/category/{category}', [BlogController::class, "category"]);
    Route::post('/', [BlogController::class, "create"]);
    Route::delete('/{id}', [BlogController::class, "delete"]);
    Route::put('/{id}', [BlogController::class, "update"]);
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoriesController::class, "index"]);
    Route::get('/{id}', [CategoriesController::class, "show"]);
    Route::post('/', [CategoriesController::class, "create"]);
    Route::delete('/{id}', [CategoriesController::class, "delete"]);
    Route::put('/{id}', [CategoriesController::class, "update"]);
});
