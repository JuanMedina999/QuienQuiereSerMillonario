<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UsuarioController;

Route::put('/questions/{id}', [QuestionController::class, 'update']);
Route::post('/register', [UsuarioController::class, 'registrarUsuario']);
Route::post('/login', [UsuarioController::class, 'autenticar']);

// Categorías
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
Route::put('/questions/{id}', [QuestionController::class, 'update']);

// Preguntas
Route::get('/questions', [QuestionController::class, 'index']);
Route::get('/questions/search', [QuestionController::class, 'search']);
Route::get('/questions/{id}', [QuestionController::class, 'show']);
Route::post('/questions', [QuestionController::class, 'store']);
Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
Route::post('/check-answer', [QuestionController::class, 'checkAnswer']);

// Juegos
Route::post('/games/start', [GameController::class, 'start']);
Route::get('/games/{game}/current-question', [GameController::class, 'currentQuestion']);
Route::post('/games/{game}/answer', [GameController::class, 'answer']);
Route::post('/games/{game}/timeout', [GameController::class, 'timeout']);
Route::get('/games/{game}/result', [GameController::class, 'result']);

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/
Route::get('/admin-data', [CategoryController::class, 'adminData']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [UsuarioController::class, 'cerrarSesion']);

});
/*
|--------------------------------------------------------------------------
| Rutas Adm
|--------------------------------------------------------------------------
*/
Route::get('/admin-data', [CategoryController::class, 'adminData']);
Route::get('/admin', function () {
    return view('admin.dashboard');
});