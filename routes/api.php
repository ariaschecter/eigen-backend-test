<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\TBookController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', [HomeController::class, 'index']);


Route::prefix('v1')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });
    Route::prefix('authors')->name('users.')->group(function () {
        Route::get('/', [AuthorController::class, 'index']);
        Route::post('/', [AuthorController::class, 'store']);
        Route::get('/{user}', [AuthorController::class, 'show']);
        Route::put('/{user}', [AuthorController::class, 'update']);
        Route::delete('/{user}', [AuthorController::class, 'destroy']);
    });
    Route::prefix('members')->name('users.')->group(function () {
        Route::get('/', [MemberController::class, 'index']);
        Route::post('/', [MemberController::class, 'store']);
        Route::get('/{user}', [MemberController::class, 'show']);
        Route::put('/{user}', [MemberController::class, 'update']);
        Route::delete('/{user}', [MemberController::class, 'destroy']);
    });
    Route::prefix('books')->name('users.')->group(function () {
        Route::get('/', [BookController::class, 'index']);
        Route::post('/', [BookController::class, 'store']);
        Route::get('/{user}', [BookController::class, 'show']);
        Route::put('/{user}', [BookController::class, 'update']);
        Route::delete('/{user}', [BookController::class, 'destroy']);
    });

    Route::prefix('borrow')->name('borrow.')->group(function () {
        Route::get('/', [TBookController::class, 'borrow'])->name('borrow');
        Route::post('/', [TBookController::class, 'storeBorrow']);
        Route::delete('/{tBook}', [TBookController::class, 'destroyBorrow'])->name('destroy');
    });

    Route::prefix('return')->name('return.')->group(function () {
        Route::get('/', [TBookController::class, 'return'])->name('return');
        Route::post('/', [TBookController::class, 'storeReturn']);
    });
});


