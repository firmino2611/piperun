<?php

//use App\Facades\TaskValidation;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TypeController;
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
Route::get('', function () {
    /** @noinspection PhpUndefinedClassInspection */
    return TaskValidation::test();
});
Route::middleware('api')
    ->prefix('auth')
    ->group(function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

    });

Route::middleware('api')
    ->prefix('tasks')
    ->group(function () {
        Route::post('', [TaskController::class, 'store']);
        Route::get('', [TaskController::class, 'index']);
        Route::get('filters/start/{start}/{end}', [TaskController::class, 'filterStart']);
        Route::get('filters/end/{start}/{end}', [TaskController::class, 'filterEnd']);

        Route::prefix('{task}')->group(function () {
            Route::get('', [TaskController::class, 'show']);
            Route::put('', [TaskController::class, 'update']);
            Route::delete('', [TaskController::class, 'destroy']);
        });

    });

Route::middleware('api')
    ->prefix('types')
    ->group(function () {

        Route::get('', [TypeController::class, 'index']);
        Route::post('', [TypeController::class, 'store']);
        Route::put('{type}', [TypeController::class, 'update']);
        Route::delete('{type}', [TypeController::class, 'destroy']);
    });
