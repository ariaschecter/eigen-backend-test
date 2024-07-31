<?php

use App\Http\ApiControllers\API\ApiAuthorController;
use App\Http\ApiControllers\API\ApiBookController;
use App\Http\ApiControllers\API\ApiHomeController;
use App\Http\ApiControllers\API\ApiMemberController;
use App\Http\ApiControllers\API\ApiTBookController;
use App\Http\ApiControllers\API\ApiUserController;
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

Route::get('/home', [ApiHomeController::class, 'index']);


Route::prefix('v1')->group(function () {
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [ApiUserController::class, 'index']);
        Route::post('/', [ApiUserController::class, 'store']);
        Route::get('/{user}', [ApiUserController::class, 'show']);
        Route::put('/{user}', [ApiUserController::class, 'update']);
        Route::delete('/{user}', [ApiUserController::class, 'destroy']);
    });
    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('/', [ApiAuthorController::class, 'index']);
        Route::post('/', [ApiAuthorController::class, 'store']);
        Route::get('/{author}', [ApiAuthorController::class, 'show']);
        Route::put('/{author}', [ApiAuthorController::class, 'update']);
        Route::delete('/{author}', [ApiAuthorController::class, 'destroy']);
    });
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [ApiMemberController::class, 'index']);
        Route::post('/', [ApiMemberController::class, 'store']);
        Route::get('/{member}', [ApiMemberController::class, 'show']);
        Route::put('/{member}', [ApiMemberController::class, 'update']);
        Route::delete('/{member}', [ApiMemberController::class, 'destroy']);
    });
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/', [ApiBookController::class, 'index']);
        Route::post('/', [ApiBookController::class, 'store']);
        Route::get('/{book}', [ApiBookController::class, 'show']);
        Route::put('/{book}', [ApiBookController::class, 'update']);
        Route::delete('/{book}', [ApiBookController::class, 'destroy']);
    });

    // TODO: here
    Route::prefix('borrow')->name('borrow.')->group(function () {
        Route::get('/', [ApiTBookController::class, 'borrow'])->name('borrow');
        Route::post('/', [ApiTBookController::class, 'storeBorrow']);
        Route::delete('/{tBook}', [ApiTBookController::class, 'destroyBorrow'])->name('destroy');
    });

    Route::prefix('return')->name('return.')->group(function () {
        Route::get('/', [ApiTBookController::class, 'return'])->name('return');
        Route::post('/', [ApiTBookController::class, 'storeReturn']);
    });
});


