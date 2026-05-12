<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CaserneController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [HomeController::class, 'accueil'])->name('home.accueil');
    Route::post('/sinistre/declarer', [\App\Http\Controllers\Home\SinistreController::class, 'store'])->name('sinistre.store');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/', [AuthController::class, 'login'])->name('admin.login.post');

    // Les routes des gestionnaires admins
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Routes Casernes
        Route::prefix('caserne')->name('admin.caserne.')->group(function () {
            Route::get('/listes', [CaserneController::class, 'index'])->name('index');
            Route::get('/ajouter', [CaserneController::class, 'create'])->name('create');
            Route::post('/ajouter', [CaserneController::class, 'store'])->name('store');
            Route::get('/archived', [CaserneController::class, 'archived'])->name('archived');
            Route::get('/{user}', [CaserneController::class, 'show'])->name('show');
            Route::get('/{user}/modifier', [CaserneController::class, 'edit'])->name('edit');
            Route::put('/{user}', [CaserneController::class, 'update'])->name('update');
            Route::delete('/{user}', [CaserneController::class, 'destroy'])->name('destroy');
        });

        // Routes Sinistres
        Route::prefix('sinistres')->name('admin.sinistre.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SinistreController::class, 'index'])->name('index');
            Route::get('/historique', [\App\Http\Controllers\Admin\SinistreController::class, 'historique'])->name('historique');
            Route::get('/{sinistre}', [\App\Http\Controllers\Admin\SinistreController::class, 'show'])->name('show');
        });

        // Routes Statistiques
        Route::prefix('statistiques')->name('admin.statistique.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\StatistiqueController::class, 'index'])->name('index');
            Route::get('/caserne/{user}', [\App\Http\Controllers\Admin\StatistiqueController::class, 'show'])->name('show');
        });

        // Routes Structures
        Route::prefix('structures')->name('admin.structure.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\StructureController::class, 'index'])->name('index');
            Route::get('/ajouter', [\App\Http\Controllers\Admin\StructureController::class, 'create'])->name('create');
            Route::post('/ajouter', [\App\Http\Controllers\Admin\StructureController::class, 'store'])->name('store');
            Route::get('/{structure}/modifier', [\App\Http\Controllers\Admin\StructureController::class, 'edit'])->name('edit');
            Route::put('/{structure}', [\App\Http\Controllers\Admin\StructureController::class, 'update'])->name('update');
            Route::post('/{structure}/resend', [\App\Http\Controllers\Admin\StructureController::class, 'resendOtp'])->name('resend');
            Route::delete('/{structure}', [\App\Http\Controllers\Admin\StructureController::class, 'destroy'])->name('destroy');
        });
    });
});

Route::prefix('structure')->name('structure.auth.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Structure\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Structure\AuthController::class, 'login'])->name('login.post');
    Route::get('/setup-password', [\App\Http\Controllers\Structure\AuthController::class, 'showSetupForm'])->name('setup');
    Route::post('/setup-password', [\App\Http\Controllers\Structure\AuthController::class, 'setupPassword'])->name('setup.post');
    Route::post('/logout', [\App\Http\Controllers\Structure\AuthController::class, 'logout'])->name('logout');

    // Mot de passe oublié
    Route::get('/forgot-password', [\App\Http\Controllers\Structure\AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Structure\AuthController::class, 'sendResetLinkEmail'])->name('password.email');
});

// Routes Protégées Structure
Route::middleware(['structure'])->prefix('structure')->name('structure.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Structure\DashboardController::class, 'index'])->name('dashboard');

    // Déclaration de sinistre
    Route::get('/sinistres', [\App\Http\Controllers\Structure\SinistreController::class, 'index'])->name('sinistre.index');
    Route::get('/sinistres/{sinistre}', [\App\Http\Controllers\Structure\SinistreController::class, 'show'])->name('sinistre.show');
    Route::post('/sinistres/{sinistre}/escalader', [\App\Http\Controllers\Structure\SinistreController::class, 'escalate'])->name('sinistre.escalate');
    Route::get('/alerte', [\App\Http\Controllers\Structure\SinistreController::class, 'create'])->name('sinistre.create');
    Route::post('/alerte', [\App\Http\Controllers\Structure\SinistreController::class, 'store'])->name('sinistre.store');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('admin.logout');

// Routes protégées pour la Caserne
Route::middleware(['auth', 'caserne'])->prefix('caserne')->name('caserne.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Caserne\CaserneController::class, 'dashboard'])->name('dashboard');
    Route::get('/rapports', [\App\Http\Controllers\Caserne\CaserneController::class, 'rapports'])->name('rapports.index');
    Route::get('/historique', [\App\Http\Controllers\Caserne\CaserneController::class, 'historique'])->name('historique.index');
    Route::get('/sinistre/{sinistre}', [\App\Http\Controllers\Caserne\CaserneController::class, 'show'])->name('sinistre.show');
    Route::get('/sinistre/{sinistre}/rapport', [\App\Http\Controllers\Caserne\CaserneController::class, 'rapport'])->name('sinistre.rapport');
    Route::post('/sinistre/{sinistre}/recuperer', [\App\Http\Controllers\Caserne\CaserneController::class, 'claim'])->name('sinistre.claim');
    Route::post('/sinistre/{sinistre}/terminer', [\App\Http\Controllers\Caserne\CaserneController::class, 'complete'])->name('sinistre.complete');
    // Route::post('/logout', [CaserneController::class, 'logout'])->name('caserne.logout');
});

// Routes d'authentification Caserne (Connexion et Configuration)
Route::prefix('caserne')->name('caserne.auth.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Caserne\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [\App\Http\Controllers\Caserne\AuthController::class, 'login'])->name('login-submit');
    Route::get('/setup-password', [\App\Http\Controllers\Caserne\AuthController::class, 'showSetupForm'])->name('setup-form');
    Route::post('/setup-password', [\App\Http\Controllers\Caserne\AuthController::class, 'setupPassword'])->name('setup-submit');
});
