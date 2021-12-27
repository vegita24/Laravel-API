<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController as Books;

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


Route::get("list", [Books::class, 'listBooks']);

Route::get("get/{id}", [Books::class, 'findBook']);

Route::post("add", [Books::class, 'addBook']);

Route::put("update", [Books::class, 'updateBook']);

Route::delete("delete/{id}", [Books::class, 'deleteBook']);


