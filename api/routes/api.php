<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileCategoryController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFileController;
use App\Models\University;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('university')->group(function () {
    Route::controller(UniversityController::class)->group(function () {
        Route::get('/view', 'view');
    });
});

Route::prefix('filecategory')->group(function () {
    Route::controller(FileCategoryController::class)->group(function () {
        Route::get('/view', 'view');
    });
});

Route::prefix('user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/emailavailability', 'emailAvailability');
        
    });
});


Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/register_with_file', 'registerWithFile');

        Route::middleware('jwt.verify')->group(function () {
            Route::get('/me', 'getAuthenticatedUser');
            Route::delete('/logout', 'logout');
        });
        
    });
});

Route::prefix('userfile')->group(function () {
    Route::middleware('jwt.verify')->group(function () {
        Route::controller(UserFileController::class)->group(function () {
            Route::post('/store', 'store');
        });

    });
});

Route::prefix('admin')->group(function () {
    Route::middleware('jwt.isadmin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/view', 'view');
            Route::get('/detail', 'detail');
            Route::patch('/approval', 'approval');
        });

    });
});
