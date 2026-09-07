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
// RUTAS PROTEGIDAS GENERALES (Autenticados)
// =====================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // DASHBOARD Y PERFIL (Todos los roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // OPERACIÓN Y ENTREGAS (Todos los roles)
    Route::get('/entregas', [EntregaController::class, 'index'])->name('entregas.index');
    Route::get('/entregas/crear', [EntregaController::class, 'create'])->name('entregas.create');
    Route::post('/entregas', [EntregaController::class, 'store'])->name('entregas.store');
    Route::get('/entregas/{entrega}', [EntregaController::class, 'show'])->name('entregas.show');
    Route::get('/entregas/{entrega}/editar', [EntregaController::class, 'edit'])->name('entregas.edit');
    Route::put('/entregas/{entrega}', [EntregaController::class, 'update'])->name('entregas.update');
    Route::delete('/entregas/{entrega}', [EntregaController::class, 'destroy'])->name('entregas.destroy');

    // ====================================================
    // CATÁLOGOS BASE (Solo Admin y Supervisor)
    // ====================================================
    Route::group(['middleware' => [function ($request, $next) {
        if (!auth()->user()->isAdmin() && !auth()->user()->isSupervisor()) {
            abort(403, 'Acceso denegado: Se requieren permisos de gestión de catálogos.');
        }
        return $next($request);
    }]], function () {

        Route::resource('localidades', LocalidadController::class)->parameters([
            'localidades' => 'localidad'
        ]);

        Route::resource('programas-sociales', ProgramaSocialController::class)->parameters([
            'programas-sociales' => 'programa_social'
        ]);

        Route::resource('beneficiarios', BeneficiarioController::class);

    });

    // ====================================================
    // ADMINISTRACIÓN DE USUARIOS (Exclusivo Administrador)
    // ====================================================
    Route::group(['middleware' => [function ($request, $next) {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Acceso denegado: Esta sección es exclusiva para la Administración del Sistema.');
        }
        return $next($request);
    }]], function () {

        Route::resource('usuarios', UserController::class);

        Route::post('/admin/usuarios/store', [UserController::class, 'storeModal'])
            ->name('admin.users.storeModal');

    });

});

require __DIR__.'/auth.php';