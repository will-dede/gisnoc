<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('incidents.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/sites/{site}/incidents', [\App\Http\Controllers\SiteController::class, 'incidents'])->name('sites.incidents');
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


















// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;
// 
// Route::get('/', function () {
//     return redirect()->route('incidents.index');
// });
// 
// // Route du dashboard commentée pour le moment
// // Route::get('/dashboard', function () {
// //     return view('dashboard');
// // })->middleware(['auth', 'verified'])->name('dashboard');
// 
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// 
//     // =========================
//     // Routes communes (tous les utilisateurs connectés)
//     // =========================
//     // Sites - Accessibles à tous les utilisateurs connectés
//     Route::get('/sites', [\App\Http\Controllers\SiteController::class, 'index'])->name('sites.index');
//     Route::get('/sites/{site}', [\App\Http\Controllers\SiteController::class, 'show'])->name('sites.show');
//     Route::get('/sites/{site}/incidents', [\App\Http\Controllers\SiteController::class, 'incidents'])->name('sites.incidents');
// 
//     // Incidents - Accessibles à tous les utilisateurs connectés
//     Route::get('/incidents', [\App\Http\Controllers\IncidentController::class, 'index'])->name('incidents.index');
//     Route::get('/incidents/{incident}', [\App\Http\Controllers\IncidentController::class, 'show'])->name('incidents.show');
// 
//     // =========================
//     // Routes accessibles aux admins ET superadmins (lecture uniquement)
//     // =========================
//     Route::middleware('role:noc_engineer')->group(function () {
//         // Régions - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/regions', [\App\Http\Controllers\RegionController::class, 'index'])->name('regions.index');
//         Route::get('/regions/{region}', [\App\Http\Controllers\RegionController::class, 'show'])->name('regions.show');
// 
//         // BSCs - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/bscs', [\App\Http\Controllers\BscController::class, 'index'])->name('bscs.index');
//         Route::get('/bscs/{bsc}', [\App\Http\Controllers\BscController::class, 'show'])->name('bscs.show');
//         Route::get('/bscs/create', [\App\Http\Controllers\BscController::class, 'create'])->name('bscs.create');
//         Route::get('/bscs/{bsc}/edit', [\App\Http\Controllers\BscController::class, 'edit'])->name('bscs.edit');
//         Route::put('/bscs/{bsc}', [\App\Http\Controllers\BscController::class, 'update'])->name('bscs.update');
//         
//         // RNCs - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/rncs', [\App\Http\Controllers\RncController::class, 'index'])->name('rncs.index');
//         Route::get('/rncs/{rnc}', [\App\Http\Controllers\RncController::class, 'show'])->name('rncs.show');
// 
//         // Types de site - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/typesite', [\App\Http\Controllers\TypeSiteController::class, 'index'])->name('typesite.index');
//         Route::get('/typesite/{typesite}', [\App\Http\Controllers\TypeSiteController::class, 'show'])->name('typesite.show');
// 
//         // Zones de maintenance - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/zonemaintenance', [\App\Http\Controllers\ZoneMaintenanceController::class, 'index'])->name('zonemaintenance.index');
//         Route::get('/zonemaintenance/{zonemaintenance}', [\App\Http\Controllers\ZoneMaintenanceController::class, 'show'])->name('zonemaintenance.show');
// 
//         // Technologies - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/technologie', [\App\Http\Controllers\TechnologieController::class, 'index'])->name('technologie.index');
//         Route::get('/technologie/{technologie}', [\App\Http\Controllers\TechnologieController::class, 'show'])->name('technologie.show');
// 
//         // Techniciens - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/techniciens', [\App\Http\Controllers\TechnicienController::class, 'index'])->name('techniciens.index');
//         Route::get('/techniciens/{technicien}', [\App\Http\Controllers\TechnicienController::class, 'show'])->name('techniciens.show');
// 
//         // Fréquences - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/frequences', [\App\Http\Controllers\FrequenceController::class, 'index'])->name('frequences.index');
//         Route::get('/frequences/{frequence}', [\App\Http\Controllers\FrequenceController::class, 'show'])->name('frequences.show');
// 
//         // Secteurs - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/secteurs', [\App\Http\Controllers\SecteurController::class, 'index'])->name('secteurs.index');
//         Route::get('/secteurs/{secteur}', [\App\Http\Controllers\SecteurController::class, 'show'])->name('secteurs.show');
// 
//         // Types d'alarme - Lecture uniquement pour noc_engineer et superadmin
//         Route::get('/typealarme', [\App\Http\Controllers\TypeAlarmeController::class, 'index'])->name('typealarme.index');
//         Route::get('/typealarme/{typealarme}', [\App\Http\Controllers\TypeAlarmeController::class, 'show'])->name('typealarme.show');
// 
//         // Sites - Création et modification pour noc_engineer et superadmin
//         Route::get('/sites/create', [\App\Http\Controllers\SiteController::class, 'create'])->name('sites.create');
//         Route::post('/sites', [\App\Http\Controllers\SiteController::class, 'store'])->name('sites.store');
//         Route::get('/sites/{site}/edit', [\App\Http\Controllers\SiteController::class, 'edit'])->name('sites.edit');
//         Route::put('/sites/{site}', [\App\Http\Controllers\SiteController::class, 'update'])->name('sites.update');
//         Route::delete('/sites/{site}', [\App\Http\Controllers\SiteController::class, 'destroy'])->name('sites.destroy');
// 
//         // Incidents - Création et modification pour noc_engineer et superadmin
//         Route::get('/incidents/create', [\App\Http\Controllers\IncidentController::class, 'create'])->name('incidents.create');
//         Route::post('/incidents', [\App\Http\Controllers\IncidentController::class, 'store'])->name('incidents.store');
//         Route::get('/incidents/{incident}/edit', [\App\Http\Controllers\IncidentController::class, 'edit'])->name('incidents.edit');
//         Route::put('/incidents/{incident}', [\App\Http\Controllers\IncidentController::class, 'update'])->name('incidents.update');
//         Route::delete('/incidents/{incident}', [\App\Http\Controllers\IncidentController::class, 'destroy'])->name('incidents.destroy');
//     });
// 
//     // =========================
//     // Routes réservées aux superadmin SEULS (création/modification)
//     // =========================
//     Route::middleware('role:superadmin')->group(function () {
//         // Utilisateurs - Gestion complète pour superadmin uniquement
//         Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
//         Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
//         Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
//         Route::get('/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
//         Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
//         Route::put('/users/{user}/validate', [\App\Http\Controllers\UserController::class, 'validateUser'])->name('users.validate');
//         Route::delete('/users/{user}/refuse', [\App\Http\Controllers\UserController::class, 'refuseUser'])->name('users.refuse');
//         Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
// 
//         // Régions - Création et modification uniquement pour superadmin
//         Route::get('/regions/create', [\App\Http\Controllers\RegionController::class, 'create'])->name('regions.create');
//         Route::post('/regions', [\App\Http\Controllers\RegionController::class, 'store'])->name('regions.store');
//         Route::get('/regions/{region}/edit', [\App\Http\Controllers\RegionController::class, 'edit'])->name('regions.edit');
//         Route::put('/regions/{region}', [\App\Http\Controllers\RegionController::class, 'update'])->name('regions.update');
//         Route::delete('/regions/{region}', [\App\Http\Controllers\RegionController::class, 'destroy'])->name('regions.destroy');
// 
//         // BSCs - Création et modification uniquement pour superadmin
//         Route::get('/bscs/create', [\App\Http\Controllers\BscController::class, 'create'])->name('bscs.create');
//         Route::post('/bscs', [\App\Http\Controllers\BscController::class, 'store'])->name('bscs.store');
//         Route::get('/bscs/{bsc}/edit', [\App\Http\Controllers\BscController::class, 'edit'])->name('bscs.edit');
//         Route::put('/bscs/{bsc}', [\App\Http\Controllers\BscController::class, 'update'])->name('bscs.update');
//         Route::delete('/bscs/{bsc}', [\App\Http\Controllers\BscController::class, 'destroy'])->name('bscs.destroy');
// 
//         // RNCs - Création et modification uniquement pour superadmin
//         Route::get('/rncs/create', [\App\Http\Controllers\RncController::class, 'create'])->name('rncs.create');
//         Route::post('/rncs', [\App\Http\Controllers\RncController::class, 'store'])->name('rncs.store');
//         Route::get('/rncs/{rnc}/edit', [\App\Http\Controllers\RncController::class, 'edit'])->name('rncs.edit');
//         Route::put('/rncs/{rnc}', [\App\Http\Controllers\RncController::class, 'update'])->name('rncs.update');
//         Route::delete('/rncs/{rnc}', [\App\Http\Controllers\RncController::class, 'destroy'])->name('rncs.destroy');
// 
//         // Types de site - Création et modification uniquement pour superadmin
//         Route::get('/typesite/create', [\App\Http\Controllers\TypeSiteController::class, 'create'])->name('typesite.create');
//         Route::post('/typesite', [\App\Http\Controllers\TypeSiteController::class, 'store'])->name('typesite.store');
//         Route::get('/typesite/{typesite}/edit', [\App\Http\Controllers\TypeSiteController::class, 'edit'])->name('typesite.edit');
//         Route::put('/typesite/{typesite}', [\App\Http\Controllers\TypeSiteController::class, 'update'])->name('typesite.update');
//         Route::delete('/typesite/{typesite}', [\App\Http\Controllers\TypeSiteController::class, 'destroy'])->name('typesite.destroy');
// 
//         // Zones de maintenance - Création et modification uniquement pour superadmin
//         Route::get('/zonemaintenance/create', [\App\Http\Controllers\ZoneMaintenanceController::class, 'create'])->name('zonemaintenance.create');
//         Route::post('/zonemaintenance', [\App\Http\Controllers\ZoneMaintenanceController::class, 'store'])->name('zonemaintenance.store');
//         Route::get('/zonemaintenance/{zonemaintenance}/edit', [\App\Http\Controllers\ZoneMaintenanceController::class, 'edit'])->name('zonemaintenance.edit');
//         Route::put('/zonemaintenance/{zonemaintenance}', [\App\Http\Controllers\ZoneMaintenanceController::class, 'update'])->name('zonemaintenance.update');
//         Route::delete('/zonemaintenance/{zonemaintenance}', [\App\Http\Controllers\ZoneMaintenanceController::class, 'destroy'])->name('zonemaintenance.destroy');
// 
//         // Technologies - Création et modification uniquement pour superadmin
//         Route::get('/technologie/create', [\App\Http\Controllers\TechnologieController::class, 'create'])->name('technologie.create');
//         Route::post('/technologie', [\App\Http\Controllers\TechnologieController::class, 'store'])->name('technologie.store');
//         Route::get('/technologie/{technologie}/edit', [\App\Http\Controllers\TechnologieController::class, 'edit'])->name('technologie.edit');
//         Route::put('/technologie/{technologie}', [\App\Http\Controllers\TechnologieController::class, 'update'])->name('technologie.update');
//         Route::delete('/technologie/{technologie}', [\App\Http\Controllers\TechnologieController::class, 'destroy'])->name('technologie.destroy');
// 
//         // Techniciens - Création et modification uniquement pour superadmin
//         Route::get('/techniciens/create', [\App\Http\Controllers\TechnicienController::class, 'create'])->name('techniciens.create');
//         Route::post('/techniciens', [\App\Http\Controllers\TechnicienController::class, 'store'])->name('techniciens.store');
//         Route::get('/techniciens/{technicien}/edit', [\App\Http\Controllers\TechnicienController::class, 'edit'])->name('techniciens.edit');
//         Route::put('/techniciens/{technicien}', [\App\Http\Controllers\TechnicienController::class, 'update'])->name('techniciens.update');
//         Route::delete('/techniciens/{technicien}', [\App\Http\Controllers\TechnicienController::class, 'destroy'])->name('techniciens.destroy');
// 
//         // Fréquences - Création et modification uniquement pour superadmin
//         Route::get('/frequences/create', [\App\Http\Controllers\FrequenceController::class, 'create'])->name('frequences.create');
//         Route::post('/frequences', [\App\Http\Controllers\FrequenceController::class, 'store'])->name('frequences.store');
//         Route::get('/frequences/{frequence}/edit', [\App\Http\Controllers\FrequenceController::class, 'edit'])->name('frequences.edit');
//         Route::put('/frequences/{frequence}', [\App\Http\Controllers\FrequenceController::class, 'update'])->name('frequences.update');
//         Route::delete('/frequences/{frequence}', [\App\Http\Controllers\FrequenceController::class, 'destroy'])->name('frequences.destroy');
// 
//         // Secteurs - Création et modification uniquement pour superadmin
//         Route::get('/secteurs/create', [\App\Http\Controllers\SecteurController::class, 'create'])->name('secteurs.create');
//         Route::post('/secteurs', [\App\Http\Controllers\SecteurController::class, 'store'])->name('secteurs.store');
//         Route::get('/secteurs/{secteur}/edit', [\App\Http\Controllers\SecteurController::class, 'edit'])->name('secteurs.edit');
//         Route::put('/secteurs/{secteur}', [\App\Http\Controllers\SecteurController::class, 'update'])->name('secteurs.update');
//         Route::delete('/secteurs/{secteur}', [\App\Http\Controllers\SecteurController::class, 'destroy'])->name('secteurs.destroy');
// 
//         // Types d'alarme - Création et modification uniquement pour superadmin
//         Route::get('/typealarme/create', [\App\Http\Controllers\TypeAlarmeController::class, 'create'])->name('typealarme.create');
//         Route::post('/typealarme', [\App\Http\Controllers\TypeAlarmeController::class, 'store'])->name('typealarme.store');
//         Route::get('/typealarme/{typealarme}/edit', [\App\Http\Controllers\TypeAlarmeController::class, 'edit'])->name('typealarme.edit');
//         Route::put('/typealarme/{typealarme}', [\App\Http\Controllers\TypeAlarmeController::class, 'update'])->name('typealarme.update');
//         Route::delete('/typealarme/{typealarme}', [\App\Http\Controllers\TypeAlarmeController::class, 'destroy'])->name('typealarme.destroy');
//     });
// 
//     // =========================
//     // Autres routes à organiser selon les besoins...
//     // =========================
//     
//     // Routes pour les relations many-to-many
//     Route::resource('siteincident', \App\Http\Controllers\SiteIncidentController::class);
//     Route::resource('sites.technologies', \App\Http\Controllers\SiteTechnologieController::class);
//     Route::resource('secteurincident', \App\Http\Controllers\SecteurIncidentController::class);
// });
// 
// Route::get('/register/success', function () {
//     return view('auth.register-success');
// })->name('register.success');
// 
// require __DIR__.'/auth.php';
// 