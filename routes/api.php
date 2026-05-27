<?php
// echo 1; die;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ApiController\ProductController;


// Route::get('tasks', function () {
//     return response()->json([
//         'message' => 'API working'
//     ]);
// });

// abhigyan pratap singh 27-05-2026
Route::post('products',[ProductController::class, 'create']);
Route::get('list/products',[ProductController::class, 'listProducts']);
Route::get('view/products/{id}',[ProductController::class, 'detail']);
Route::put('update/products/{id}',[ProductController::class, 'update']);
Route::delete('delete/products/{id}',[ProductController::class, 'delete']);