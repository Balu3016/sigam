<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\ProgramaSocialController;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// =====================================
// RUTAS PROTEGIDAS SIGAM
// =====================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // -------------------------------------
    // DASHBOARD PRINCIPAL
    // -------------------------------------
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // -------------------------------------
    // PERFIL DE USUARIO (Breeze)
    // -------------------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -------------------------------------
    // 1. CATÁLOGOS BASE (Creación Individual)
    // -------------------------------------
    Route::resource('localidades', LocalidadController::class)->parameters([
        'localidades' => 'localidad'
    ]);

    Route::resource('programas-sociales', ProgramaSocialController::class)->parameters([
        'programas-sociales' => 'programa_social'
    ]);

    Route::resource('beneficiarios', BeneficiarioController::class);

    // -------------------------------------
    // 2. OPERACIÓN CONJUNTA (Asignación y Entregas)
    // -------------------------------------
    Route::resource('entregas', EntregaController::class)->except(['edit', 'update']);

    // -------------------------------------
    // 3. ADMINISTRACIÓN DE USUARIOS (AJAX Modal)
    // -------------------------------------
    Route::post('/admin/usuarios/store', [UserController::class, 'storeModal'])
        ->name('admin.users.storeModal');

});

require __DIR__.'/auth.php';