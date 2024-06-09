<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DemandeController;
use Spatie\Permission\Middlewares\RoleMiddleware;
use App\Http\Controllers\DashboardController;

// Import du modèle User si ce n'est pas déjà fait
use App\Models\User;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SousModuleController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\Auth\ForgotPasswordController;




// Route pour afficher le formulaire de login
Route::get('/login', function () {
    return view('login');
})->name('login');

 
// Route pour traiter le login
Route::post('/login', [UserController::class, 'login'])->name('loginpost');

 

// Route pour déconnecter l'utilisateur et dashboard 
Route::middleware(['auth' ])->group(function () {
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('dashboard/download{pdfFileName}', [DashboardController::class, 'downloadPdf'])->name('dashboard.download');

});

// Routes pour l'admin'
Route::middleware(['auth', 'role:Admin'])->group(function () {
    //MODULE

Route::get('/modulesroute', [ModuleController::class, 'index'])->name('modules.indexmodules');
Route::get('/modulesroute/create', [ModuleController::class, 'create'])->name('modules.create');
Route::post('/modulesroute', [ModuleController::class, 'store'])->name('modules.store'); 
Route::get('/modulesroute/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
Route::put('/modulesroute/{module}', [ModuleController::class, 'update'])->name('modules.update');
Route::delete('/modulesroute/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
//sousmodules
Route::get('/sousmodulesroute', [SousModuleController::class, 'index'])->name('sousmodules.indexsousmodules');
Route::get('/sousmodulesroute/create', [SousModuleController::class, 'create'])->name('sousmodules.create');
Route::post('/sousmodulesroute', [SousModuleController::class, 'store'])->name('sousmodules.store'); 
Route::get('/sousmodulesroute/{sousmodule}/edit', [SousModuleController::class, 'edit'])->name('sousmodules.edit');
Route::put('/sousmodulesroute/{sousmodule}', [SousModuleController::class, 'update'])->name('sousmodules.update');
Route::delete('/sousmodulesroute/{sousmodule}', [SousModuleController::class, 'destroy'])->name('sousmodules.destroy');
//departements
Route::get('/departementsroute', [DepartementController::class, 'index'])->name('departements.indexdepartements');
Route::get('/departementsroute/create', [DepartementController::class, 'create'])->name('departements.create');
Route::post('/departementsroute', [DepartementController::class, 'store'])->name('departements.store');
Route::get('/departementsroute/{departement}', [DepartementController::class, 'show'])->name('departements.show');
Route::get('/departementsroute/{departement}/edit', [DepartementController::class, 'edit'])->name('departements.edit');
Route::put('/departementsroute/{departement}', [DepartementController::class, 'update'])->name('departements.update');
Route::delete('/departementsroute/{departement}', [DepartementController::class, 'destroy'])->name('departements.destroy');
//division
Route::get('/divisionsroute', [DivisionController::class, 'index'])->name('divisions.index');
Route::get('/divisionsroute/create', [DivisionController::class, 'create'])->name('divisions.create');
Route::post('/divisionsroute', [DivisionController::class, 'store'])->name('divisions.store'); 
Route::get('/divisionsroute/{division}/edit', [DivisionController::class, 'edit'])->name('divisions.edit');
Route::put('/divisionsroute/{division}', [DivisionController::class, 'update'])->name('divisions.update');
Route::delete('/divisionsroute/{division}', [DivisionController::class, 'destroy'])->name('divisions.destroy');
//services
Route::get('servicesroute', [ServiceController::class, 'index'])->name('services.index');
Route::get('servicesroute/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('servicesroute', [ServiceController::class, 'store'])->name('services.store');
Route::get('servicesroute/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::get('servicesroute/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('servicesroute/{service}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('servicesroute/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

//CRUD USER
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/create', function () {
        return view('createusers');
    })->name('users.create');
    Route::get('/roles', [UserController::class, 'getAllRoles'])->name('getallroles');

    Route::post('/create', [UserController::class, 'register'])->name('users.register');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('users.update'); // Route pour afficher le formulaire d'édition
    Route::delete('/users/{id}', [UserController::class, 'delete'])->name('users.delete');
});
//routes pour chef division
Route::middleware(['auth','role:Chef division'])->group(function () {
    Route::get('/demandes', [DemandeController::class,'index'])->name('demandes.index');
    Route::post('/demandes/create', [DemandeController::class, 'create'])->name('demandes.create');
    Route::get('/modules', [DemandeController::class,'getAllModules'])->name('demandes.modules');
    Route::get('/sousmodules', [DemandeController::class,'getSousModules'])->name('demandes.sousmodules');
    Route::get('/departements', [DemandeController::class, 'getAllDepartements']);
    Route::get('/services', [DemandeController::class, 'getServicesByDivision']);

    Route::get('/demandes/create', function () {
        return view('demandes.createdemande');})->name('demandes.createform');
    });
//routes pour directeur 
Route::middleware(['auth','role:Directeur'])->group(function () {

    Route::get('/demandes/validate',  [DemandeController::class,'index2'])->name('demandes.validateform');
   
    Route::get('/demandes/edit/{id}', [DemandeController::class, 'edit'])->name('demandes.edit');
    Route::put('/demandes/update/{id}', [DemandeController::class, 'update'])->name('demandes.update');
    Route::put('/demandes/validate/{id}', [DemandeController::class, 'validateDemande'])->name('demandes.validate');
});
//routes pour chef service 
Route::middleware(['auth','role:Chef service'])->group(function () {
Route::post('/demandes/{id}/updateStatus', [DemandeController::class,'updateStatus'])->name('demandes.updateStatus');
Route::get('/demandes/process', [DemandeController::class, 'process'])->name('demandes.process');
Route::post('/demandes/{id}/addAttachment', [DemandeController::class,'addAttachment'])->name('demandes.addAttachment');

});


