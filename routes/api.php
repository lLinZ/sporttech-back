<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

/**---------------------
 * RUTAS SIN TOKEN
 * ---------------------**/
// Registrar master
Route::post('register/master/24548539', [AuthController::class, 'register_master']);
// Login
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    /**---------------------
     * USERS
     * ---------------------**/
    // Validacion de token
    Route::get('user/data', [AuthController::class, 'get_logged_user_data']);
    // Registrar usuario
    Route::put('user/{user}/change/color', [AuthController::class, 'edit_color']);
    Route::put('user/{user}/change/theme', [AuthController::class, 'edit_theme']);
    Route::put('user/{user}/change/password', [AuthController::class, 'edit_password']);
    // Cerrar sesion
    Route::get('logout', [AuthController::class, 'logout']);

    /**---------------------
     * PLAYERS
     * ---------------------**/
    // Paginacion de jugadores
    Route::get('players', [PlayerController::class, 'index']);
    // Registrar jugador
    Route::post('players/add', [PlayerController::class, 'store']);

    /**---------------------
     * TEAMS
     * ---------------------**/
    // Registrar equipo
    Route::get('teams/all', [TeamController::class, 'all']);
    // Paginacion de equipos
    Route::get('teams', [TeamController::class, 'index']);
    // Registrar equipo
    Route::post('teams/add', [TeamController::class, 'store']);

    /**---------------------
     * CATEGORIES
     * ---------------------**/
    // Paginacion de equipos
    Route::get('categories/all', [CategoryController::class, 'all']);
    Route::get('categories', [CategoryController::class, 'index']);
    // Registrar equipo
    Route::post('categories/add', [CategoryController::class, 'store']);

    /**---------------------
     * DISCIPLINES
     * ---------------------**/
    // Todas las disciplinas
    Route::get('disciplines/all', [DisciplineController::class, 'all']);
    // Paginacion de disciplinas
    Route::get('disciplines', [DisciplineController::class, 'index']);
    // Registrar disciplina
    Route::post('disciplines/add', [DisciplineController::class, 'store']);

    /**---------------------
     * LEAGUES
     * ---------------------**/
    // Todas las disciplinas
    Route::get('leagues/all', [LeagueController::class, 'all']);
    // Paginacion de disciplinas
    Route::get('leagues', [LeagueController::class, 'index']);
    // Registrar disciplina
    Route::post('leagues/add', [LeagueController::class, 'store']);

    /**---------------------
     * CLUBS
     * ---------------------**/
    // Todos los clubs
    Route::get('clubs/all', [ClubController::class, 'all']);
    // Paginacion de clubs
    Route::get('clubs', [ClubController::class, 'index']);
    // Registrar club
    Route::post('clubs/add', [ClubController::class, 'store']);
});
