<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UsuarioController;

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando Att: MEDINA999']);
});

Route::post('/register', [UsuarioController::class, 'registrarUsuario']);
Route::post('/login', [UsuarioController::class, 'autenticar']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [UsuarioController::class, 'cerrarSesion']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::get('/questions', [QuestionController::class, 'index']);
    Route::get('/questions/search', [QuestionController::class, 'search']);
    Route::get('/questions/{id}', [QuestionController::class, 'show']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
    Route::post('/check-answer', [QuestionController::class, 'checkAnswer']);

    Route::post('/games/start', [GameController::class, 'start']);
    Route::get('/games/{game}/current-question', [GameController::class, 'currentQuestion']);
    Route::post('/games/{game}/answer', [GameController::class, 'answer']);
    Route::post('/games/{game}/timeout', [GameController::class, 'timeout']);
    Route::get('/games/{game}/result', [GameController::class, 'result']);

});