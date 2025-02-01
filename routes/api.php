<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\StadiumController;
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
     * CONTACTS
     * ---------------------**/
    // Paginacion de jugadores
    Route::get('contacts', [PlayerController::class, 'index']);
    // Paginacion de jugadores
    Route::get('contact/{player}', [PlayerController::class, 'get_player_by_id']);
    // Registrar jugador
    Route::post('contacts/add', [PlayerController::class, 'store']);

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

    /**---------------------
     * STADIUMS
     * ---------------------**/
    // Todos los stadiums
    Route::get('stadiums/all', [StadiumController::class, 'all']);
    // Paginacion de stadiums
    Route::get('stadiums', [StadiumController::class, 'index']);
    // Registrar stadiums
    Route::post('stadiums/add', [StadiumController::class, 'store']);
    // Registrar localizacion
    Route::post('stadiums/{stadium}/location/add', [LocationController::class, 'store']);
    // Localizaciones por id de Stadium
    Route::get('stadiums/{stadium}/locations', [LocationController::class, 'get_locations_by_stadium']);
    // Todas las localizaciones de stadiums
    Route::get('stadiums/locations/all', [LocationController::class, 'all']);

    /**---------------------
     * QUOTATIONS
     * ---------------------**/
    //  Todas las cotizaciones
    Route::get('quotations/all', [QuotationController::class, 'all']);
    // Paginacion de cotizaciones
    Route::get('quotations', [QuotationController::class, 'index']);
    // Paginacion de cotizaciones por cliente
    Route::get('quotations/client', [QuotationController::class, 'index_by_client']);
    // Paginacion de cotizaciones por cliente
    Route::get('quotations/latest', [QuotationController::class, 'latest']);
    // Registrar cotizacion
    Route::post('quotations/add', [QuotationController::class, 'store']);
    Route::get('quotations/{quotation}', [QuotationController::class, 'get_quotation_by_id']);

    /**---------------------
     * BRANDS
     * ---------------------**/
    //  Todas las cotizaciones
    Route::get('brands/all', [BrandController::class, 'all']);
    // Paginacion de cotizaciones
    Route::get('brands', [BrandController::class, 'index']);
    // Registrar cotizacion
    Route::post('brands/add', [BrandController::class, 'store']);

    /**---------------------
     * CLIENTS
     * ---------------------**/
    //  Todas las cotizaciones
    Route::get('clients/all', [ClientController::class, 'all']);
    // Paginacion de cotizaciones
    Route::get('clients', [ClientController::class, 'index']);
    // Registrar cotizacion
    Route::post('clients/add', [ClientController::class, 'store']);
});
