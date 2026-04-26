<?php

use App\Http\Controllers\Api\CandidatureController;
use App\Http\Controllers\Api\CentreController;
use App\Http\Controllers\Api\EcoleController;
use App\Http\Controllers\Api\MatiereController;
use App\Http\Controllers\Api\PosteController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * Routes API de l'application.
 *
 * - Authentification publique : connexion et inscription.
 * - Ressources protégées : accès avec token Sanctum.
 */

/**
 * Endpoints publics d'authentification.
 */
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/**
 * Endpoints nécessitant un utilisateur authentifié.
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * Endpoints protégés avec limitation de débit API.
     */
    Route::middleware('throttle:api')->group(function () {

        Route::get('/postes', [PosteController::class, 'index']);
        Route::post('/postes', [PosteController::class, 'store']);
        Route::get('/postes/{id}', [PosteController::class, 'show']);
        Route::delete('/postes/{id}', [PosteController::class, 'destroy']);

        Route::get('/postes/{poste_id}/candidatures', [CandidatureController::class, 'parPoste']);
        Route::post('/postes/{poste_id}/candidatures', [CandidatureController::class, 'store']);

        Route::get('/postes/{poste_id}/matieres', [MatiereController::class, 'parPoste']);
        Route::post('/postes/{poste_id}/matieres', [MatiereController::class, 'associer']);

        Route::get('/ecoles', [EcoleController::class, 'index']);
        Route::get('/ecoles/{id}', [EcoleController::class, 'show']);
        Route::get('/ecoles/{id}/postes', [EcoleController::class, 'postes']);

        Route::get('/centres', [CentreController::class, 'index']);
        Route::get('/centres/stats', [CentreController::class, 'stats']);
        Route::get('/centres/{id}/postes', [CentreController::class, 'postes']);

        Route::get('/candidatures', [CandidatureController::class, 'index']);

        Route::get('/matieres', [MatiereController::class, 'index']);
    });
});
