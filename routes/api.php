<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Citizen\SinistreApiController;
use App\Http\Controllers\Api\Groupe\GroupeAuthApiController;
use App\Http\Controllers\Api\Groupe\GroupeSinistreApiController;

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

// ─── Routes Citoyens (Déclaration de sinistre) ───────────────────────────────
Route::prefix('citizen')->group(function () {
    Route::post('/sinistre/declarer', [SinistreApiController::class, 'store']);
});

// ─── Routes Groupe : Authentification (publiques) ────────────────────────────
Route::prefix('groupe')->group(function () {
    Route::post('/login', [GroupeAuthApiController::class, 'login']);
    // Route PDF avec authentification manuelle via token en query
    Route::get('/sinistre/{sinistre}/pdf', [GroupeSinistreApiController::class, 'downloadPdf']);
});

// ─── Routes Groupe : Fonctionnalités (protégées par Sanctum) ─────────────────
Route::prefix('groupe')
    ->middleware(['auth:sanctum', 'groupe.api'])
    ->group(function () {

    // Profil et déconnexion
    Route::get('/profil',  [GroupeAuthApiController::class, 'profil']);
    Route::post('/logout', [GroupeAuthApiController::class, 'logout']);

    // Tableau de bord (sinistres en attente)
    Route::get('/dashboard', [GroupeSinistreApiController::class, 'dashboard']);

    // Interventions en cours
    Route::get('/interventions', [GroupeSinistreApiController::class, 'interventions']);

    // Interventions terminées
    Route::get('/interventions-terminees', [GroupeSinistreApiController::class, 'interventionsTerminees']);

    // Détail d'un sinistre
    Route::get('/sinistre/{sinistre}', [GroupeSinistreApiController::class, 'show']);

    // Démarrer une intervention (claim)
    Route::post('/sinistre/{sinistre}/demarrer', [GroupeSinistreApiController::class, 'demarrer']);

    // Soumettre l'état des lieux et clôturer
    Route::post('/sinistre/{sinistre}/etat-des-lieux', [GroupeSinistreApiController::class, 'etatDesLieux']);
});
