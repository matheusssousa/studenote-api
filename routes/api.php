<?php

use App\Http\Controllers\Auth\AuthController as AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Auth\Notifications\ResetPassword;
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
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [ResetPasswordController::class, 'reset']);

Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/verification-notification', [VerificationController::class, 'resend']);

Route::middleware('jwt.auth')->group(function(){
    Route::apiResource('dashboard', DashboardController::class);
    Route::apiResource('comentario', ComentarioController::class);
    Route::apiResource('community', CommunityController::class);
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('disciplina', DisciplinaController::class);
    Route::apiResource('favorite', FavoritesController::class);

    Route::apiResource('notas', NotasController::class);
    Route::get('notas/recentes/as', [NotasController::class, 'recentes']);
    Route::patch('notas/{nota}/community', [NotasController::class, 'addComunidade']);
    Route::patch('notas/{nota}/like', [NotasController::class, 'likeNote']);

    Route::get('community/popular/tree', [CommunityController::class, 'popular']);

    Route::apiResource('user', UserController::class);
    Route::get('users', [UserController::class, 'showAll']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('user/password/{id}', [UserController::class, 'updatePassword']);

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});
