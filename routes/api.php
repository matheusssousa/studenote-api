<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware('jwt-auth')->group(function(){
    Route::apiResource('comentario', ComentarioController::class);
    Route::apiResource('community', CommunityController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('disciplina', DisciplinaController::class);

    Route::apiResource('notas', NotasController::class);
    Route::patch('notas/{nota}/community', [NotasController::class, 'addComunidade']);

    Route::get('users', [UserController::class, 'showAll']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::apiResource('user', UserController::class);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
