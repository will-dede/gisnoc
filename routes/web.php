<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour la gestion des utilisateurs
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/validate', [\App\Http\Controllers\UserController::class, 'validateUser'])->name('users.validate');
    Route::delete('/users/{user}/refuse', [\App\Http\Controllers\UserController::class, 'refuseUser'])->name('users.refuse');
    Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');

    Route::resource('regions', \App\Http\Controllers\RegionController::class);
    Route::resource('secteurs', \App\Http\Controllers\SecteurController::class);
    Route::resource('sites', \App\Http\Controllers\SiteController::class);
    Route::resource('techniciens', \App\Http\Controllers\TechnicienController::class);
    // Route::resource('mecaniciens', \App\Http\Controllers\MecanicienController::class);
    Route::resource('incidents', \App\Http\Controllers\IncidentController::class);
    Route::resource('frequences', \App\Http\Controllers\FrequenceController::class);
    Route::resource('bscs', \App\Http\Controllers\BscController::class);
    Route::resource('rncs', \App\Http\Controllers\RncController::class);
    Route::resource('typesite', \App\Http\Controllers\TypeSiteController::class);
    Route::resource('typealarme', \App\Http\Controllers\TypeAlarmeController::class);
    Route::resource('technologie', \App\Http\Controllers\TechnologieController::class);
    Route::resource('zonemaintenance', \App\Http\Controllers\ZoneMaintenanceController::class);
    Route::resource('siteincident', \App\Http\Controllers\SiteIncidentController::class);
    Route::resource('sites.technologies', \App\Http\Controllers\SiteTechnologieController::class);
    Route::resource('secteurincident', \App\Http\Controllers\SecteurIncidentController::class);
});

Route::get('/register/success', function () {
    return view('auth.register-success');
})->name('register.success');

require __DIR__.'/auth.php';
